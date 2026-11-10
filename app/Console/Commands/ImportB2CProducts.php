<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class ImportB2CProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'b2c:import-products
                            {file=ProductList.csv : Path to the POS product list CSV}
                            {--dry-run : Show what would change without writing to the database}
                            {--stock=1000 : Default stock quantity for newly created B2C products}
                            {--fuzzy=93 : Minimum similarity percentage when matching legacy products by name (0 disables)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update B2C products from the POS product list. The CSV ProductId is stored as the product stock number.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $filePath = $this->resolveFilePath($this->argument('file'));

        if (! $filePath) {
            $this->error('File not found: ' . $this->argument('file'));

            return self::FAILURE;
        }

        $handle = fopen($filePath, 'r');

        if (! $handle) {
            $this->error('Could not open file: ' . $filePath);

            return self::FAILURE;
        }

        $header = fgetcsv($handle, 0, ',', '"', '');

        if (! $header) {
            fclose($handle);
            $this->error('The CSV file is empty or has no header row.');

            return self::FAILURE;
        }

        $columns = $this->mapColumns($header);

        if (! isset($columns['name'])) {
            fclose($handle);
            $this->error('The CSV file must contain a "Name" column.');

            return self::FAILURE;
        }

        $dryRun = (bool) $this->option('dry-run');
        $defaultStock = max(0, (int) $this->option('stock'));
        $fuzzyThreshold = max(0, min(100, (float) $this->option('fuzzy')));

        $this->info(($dryRun ? '[DRY RUN] ' : '') . "Importing B2C products from: {$filePath}");

        /** @var \Illuminate\Support\Collection<int, Product> $products */
        $products = Product::where('is_b2b', false)->get();

        $byStockNumber = [];
        $byBarcode = [];
        $bySlug = [];
        $byTitle = [];

        foreach ($products as $product) {
            $this->indexProduct($product, $byStockNumber, $byBarcode, $bySlug, $byTitle);
        }

        $fuzzyCandidates = $this->buildFuzzyCandidates($products);

        $stats = [
            'rows' => 0,
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'categories_created' => 0,
            'errors' => 0,
        ];

        $errors = [];

        DB::beginTransaction();

        try {
            while (($data = fgetcsv($handle, 0, ',', '"', '')) !== false) {
                if ($this->isEmptyRow($data)) {
                    continue;
                }

                $stats['rows']++;

                $row = $this->readRow($data, $columns);
                $name = $this->cleanValue($row['name'] ?? '');
                $price = $this->toDecimal($row['salepriceinctax'] ?? null);

                if (! $this->isValidProductName($name)) {
                    $stats['skipped']++;
                    continue;
                }

                if ($price === null || $price <= 0) {
                    $stats['skipped']++;
                    $this->warn("Skipped zero/invalid price: {$name}");
                    continue;
                }

                $stockNumber = $this->cleanValue($row['productid'] ?? '');
                $barcodes = $this->parseBarcodes($row['barcode'] ?? '');
                $firstBarcode = $barcodes[0] ?? null;
                $description = $this->cleanValue($row['description'] ?? '');
                $categoryId = $this->resolveCategoryId($row['category'] ?? '', $dryRun, $stats);

                $product = $this->findExistingProduct(
                    $stockNumber,
                    $firstBarcode,
                    $name,
                    $byStockNumber,
                    $byBarcode,
                    $bySlug,
                    $byTitle,
                    $fuzzyCandidates,
                    $fuzzyThreshold
                );

                if ($product) {
                    $oldStockNumber = (string) $product->stock_number;
                    $oldBarcodes = $this->parseBarcodes($product->barcode ?? '');

                    if ($dryRun) {
                        $stats['updated']++;
                        $this->line("Would update: {$product->title} (stock #{$stockNumber}) - £{$product->price} => £{$price}");
                        continue;
                    }

                    $attributes = $this->buildUpdateAttributes(
                        $product,
                        $row,
                        $price,
                        $stockNumber,
                        $barcodes,
                        $categoryId,
                        $description
                    );

                    $product->fill($attributes);
                    $product->saveQuietly();

                    if ($oldStockNumber !== '' && isset($byStockNumber[$oldStockNumber]) && $byStockNumber[$oldStockNumber]->is($product)) {
                        unset($byStockNumber[$oldStockNumber]);
                    }

                    foreach ($oldBarcodes as $oldBarcode) {
                        if (isset($byBarcode[$oldBarcode]) && $byBarcode[$oldBarcode]->is($product)) {
                            unset($byBarcode[$oldBarcode]);
                        }
                    }

                    $this->indexProduct($product, $byStockNumber, $byBarcode, $bySlug, $byTitle);
                    $fuzzyCandidates = $this->appendFuzzyCandidate($fuzzyCandidates, $product);
                    $stats['updated']++;

                    $this->line("Updated: {$product->title} (stock #{$stockNumber}) - £{$price}");

                    continue;
                }

                if ($dryRun) {
                    $stats['created']++;
                    $this->line("Would create: {$name} (stock #{$stockNumber}) - £{$price}");
                    continue;
                }

                $attributes = $this->buildCreateAttributes(
                    $row,
                    $name,
                    $price,
                    $stockNumber,
                    $barcodes,
                    $categoryId,
                    $description,
                    $defaultStock
                );

                $product = Product::create($attributes);
                $this->indexProduct($product, $byStockNumber, $byBarcode, $bySlug, $byTitle);
                $fuzzyCandidates = $this->appendFuzzyCandidate($fuzzyCandidates, $product);
                $stats['created']++;

                $this->line("Created: {$product->title} (stock #{$stockNumber}) - £{$price}");
            }

            if ($dryRun) {
                DB::rollBack();
            } else {
                DB::commit();
            }
        } catch (Throwable $e) {
            DB::rollBack();
            $stats['errors']++;
            $errors[] = $e->getMessage();

            $this->error('Import failed: ' . $e->getMessage());
            Log::error('B2C product import failed: ' . $e->getMessage(), [
                'file' => $filePath,
                'trace' => $e->getTraceAsString(),
            ]);
        } finally {
            fclose($handle);
        }

        $this->newLine();
        $this->table(
            ['Rows', 'Created', 'Updated', 'Skipped', 'Categories created', 'Errors'],
            [[
                $stats['rows'],
                $stats['created'],
                $stats['updated'],
                $stats['skipped'],
                $stats['categories_created'],
                $stats['errors'],
            ]]
        );

        if ($dryRun) {
            $this->warn('Dry run complete. No database changes were written.');
        }

        if ($errors) {
            $this->error('Errors: ' . implode(' | ', $errors));

            return self::FAILURE;
        }

        Log::info('B2C product import completed.', $stats);

        return self::SUCCESS;
    }

    /**
     * Resolve the CSV path from the common locations used by the project.
     */
    private function resolveFilePath(string $file): ?string
    {
        $possiblePaths = [
            $file,
            base_path($file),
            storage_path('app/' . $file),
            storage_path($file),
            public_path($file),
        ];

        foreach ($possiblePaths as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Map the CSV headers to simple, normalized keys.
     *
     * @param  array<int, string|null>  $header
     * @return array<string, int>
     */
    private function mapColumns(array $header): array
    {
        $columns = [];

        foreach ($header as $position => $column) {
            $key = Str::of((string) $column)
                ->replace("\xEF\xBB\xBF", '')
                ->lower()
                ->replaceMatches('/[^a-z0-9]+/', '')
                ->toString();

            if ($key !== '') {
                $columns[$key] = $position;
            }
        }

        return $columns;
    }

    /**
     * @param  array<int, string|null>  $data
     * @param  array<string, int>  $columns
     * @return array<string, string>
     */
    private function readRow(array $data, array $columns): array
    {
        $row = [];

        foreach ($columns as $key => $position) {
            $row[$key] = $this->cleanValue($data[$position] ?? null);
        }

        return $row;
    }

    /**
     * @param  array<int, string|null>  $data
     */
    private function isEmptyRow(array $data): bool
    {
        foreach ($data as $value) {
            if ($this->cleanValue($value) !== '') {
                return false;
            }
        }

        return true;
    }

    private function cleanValue(mixed $value): string
    {
        if ($value === null) {
            return '';
        }

        $value = str_replace(["\xC2\xA0", "\xE2\x80\xAF"], ' ', (string) $value);
        $value = preg_replace('/^\xEF\xBB\xBF/', '', $value);

        return trim($value);
    }

    private function isValidProductName(string $name): bool
    {
        if ($name === '' || in_array($name, ['<', '.', '-', '--'], true)) {
            return false;
        }

        return (bool) preg_match('/[a-z0-9]/i', $name);
    }

    private function toDecimal(?string $value): ?float
    {
        $value = $this->cleanValue($value);

        if ($value === '') {
            return null;
        }

        $value = str_replace([',', '£', '$', ' '], '', $value);

        return is_numeric($value) ? (float) $value : null;
    }

    /**
     * @return array<int, string>
     */
    private function parseBarcodes(?string $value): array
    {
        $value = $this->cleanValue($value);

        if ($value === '') {
            return [];
        }

        $barcodes = array_map(fn (string $barcode): string => $this->cleanValue($barcode), explode(',', $value));
        $barcodes = array_filter($barcodes, fn (string $barcode): bool => $barcode !== '');

        return array_values(array_unique($barcodes));
    }

    private function normalizeTitle(?string $title): string
    {
        $title = Str::ascii((string) $title);
        $title = str_replace('&', ' and ', $title);
        $title = preg_replace('/[^a-z0-9]+/', ' ', strtolower($title));

        return trim(preg_replace('/\s+/', ' ', (string) $title));
    }

    private function resolveCategoryId(string $categoryName, bool $dryRun, array &$stats): ?int
    {
        $categoryName = $this->cleanValue($categoryName) ?: 'Uncategorized';
        $slug = Str::slug($categoryName);

        $category = Category::where('slug', $slug)->first();

        if ($category) {
            return $category->id;
        }

        if ($dryRun) {
            return null;
        }

        $category = Category::create([
            'title' => $categoryName,
            'slug' => $slug,
        ]);

        $stats['categories_created']++;

        return $category->id;
    }

    /**
     * @param  array<string, Product>  $byStockNumber
     * @param  array<string, Product>  $byBarcode
     * @param  array<string, Product>  $bySlug
     * @param  array<string, Product>  $byTitle
     * @param  array<int, array{product: Product, normalized: string, size: array<int, string>}>  $fuzzyCandidates
     */
    private function findExistingProduct(
        string $stockNumber,
        ?string $barcode,
        string $name,
        array $byStockNumber,
        array $byBarcode,
        array $bySlug,
        array $byTitle,
        array $fuzzyCandidates,
        float $fuzzyThreshold
    ): ?Product {
        if ($stockNumber !== '' && isset($byStockNumber[$stockNumber])) {
            return $byStockNumber[$stockNumber];
        }

        if ($barcode && isset($byBarcode[$barcode])) {
            $barcodeCandidate = $byBarcode[$barcode];

            if ((string) $barcodeCandidate->stock_number === '' || (string) $barcodeCandidate->stock_number === $stockNumber) {
                return $barcodeCandidate;
            }
        }

        $slug = Str::slug($name);
        $candidate = $bySlug[$slug] ?? $byTitle[$this->normalizeTitle($name)] ?? null;

        // Only fall back to a name match when the existing product has no stock
        // number yet, or when it already has this same stock number. This stops
        // duplicate CSV names (e.g. "Couscous") from overwriting one another.
        if ($candidate && ((string) $candidate->stock_number === '' || (string) $candidate->stock_number === $stockNumber)) {
            return $candidate;
        }

        if ($fuzzyThreshold > 0) {
            return $this->findFuzzyProduct($name, $stockNumber, $fuzzyCandidates, $fuzzyThreshold);
        }

        return null;
    }

    /**
     * Build the normalized title/size data used for legacy name matching.
     *
     * @param  \Illuminate\Support\Collection<int, Product>  $products
     * @return array<int, array{product: Product, normalized: string, size: array<int, string>}>
     */
    private function buildFuzzyCandidates($products): array
    {
        return $products->map(fn (Product $product): array => [
            'product' => $product,
            'normalized' => $this->normalizeTitle($product->title),
            'size' => $this->sizeSignature($product->title),
        ])->all();
    }

    /**
     * @param  array<int, array{product: Product, normalized: string, size: array<int, string>}>  $candidates
     * @return array<int, array{product: Product, normalized: string, size: array<int, string>}>
     */
    private function appendFuzzyCandidate(array $candidates, Product $product): array
    {
        $candidates[] = [
            'product' => $product,
            'normalized' => $this->normalizeTitle($product->title),
            'size' => $this->sizeSignature($product->title),
        ];

        return $candidates;
    }

    /**
     * Find a legacy product whose name is very close to the CSV name and whose
     * size/pack signature is identical. This lets the first import update old
     * records that were created before stock numbers existed, without matching
     * different sizes or brands of the same product.
     *
     * @param  array<int, array{product: Product, normalized: string, size: array<int, string>}>  $candidates
     */
    private function findFuzzyProduct(
        string $name,
        string $stockNumber,
        array $candidates,
        float $threshold
    ): ?Product {
        $normalizedName = $this->normalizeTitle($name);
        $size = $this->sizeSignature($name);

        $bestProduct = null;
        $bestScore = 0.0;

        foreach ($candidates as $candidate) {
            /** @var Product $product */
            $product = $candidate['product'];

            // Never steal a product that already belongs to another stock number.
            if ((string) $product->stock_number !== '' && (string) $product->stock_number !== $stockNumber) {
                continue;
            }

            // A size or pack count must match exactly (including "no size").
            if ($candidate['size'] !== $size) {
                continue;
            }

            similar_text($normalizedName, $candidate['normalized'], $percent);

            if ($percent > $bestScore) {
                $bestScore = $percent;
                $bestProduct = $product;
            }
        }

        return $bestScore >= $threshold ? $bestProduct : null;
    }

    /**
     * Extract weight, volume and pack-count tokens so fuzzy matches do not cross
     * different sizes (e.g. "1kg" must not match "2kg").
     *
     * @return array<int, string>
     */
    private function sizeSignature(?string $title): array
    {
        $title = $this->normalizeTitle($title);
        $sizes = [];

        if (preg_match_all('/(\d+(?:\.\d+)?)\s*(kg|kgs|g|gram|grams|l|ltr|litre|litres|ml|k)\b/', $title, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $value = (float) $match[1];
                $unit = $match[2];

                $unit = match ($unit) {
                    'k', 'kgs' => 'kg',
                    'gram', 'grams' => 'g',
                    'ltr', 'litre', 'litres' => 'l',
                    default => $unit,
                };

                $sizes[] = $value . $unit;
            }
        }

        if (preg_match_all('/(?:pack|pk|box|crate)\s*(?:of)?\s*(\d+)/', $title, $matches)) {
            foreach ($matches[1] as $count) {
                $sizes[] = $count . 'pack';
            }
        }

        if (preg_match_all('/(\d+)\s*(?:pcs|pieces|can|cans)\b/', $title, $matches)) {
            foreach ($matches[1] as $count) {
                $sizes[] = $count . 'pack';
            }
        }

        // Treat a trailing standalone number as a pack count (e.g. "Hungryman 3").
        if (empty($sizes) && preg_match('/\b(\d+)\s*$/', $title, $match)) {
            $sizes[] = $match[1] . 'pack';
        }

        $sizes = array_values(array_unique($sizes));
        sort($sizes);

        return $sizes;
    }

    /**
     * @param  array<string, Product>  $byStockNumber
     * @param  array<string, Product>  $byBarcode
     * @param  array<string, Product>  $bySlug
     * @param  array<string, Product>  $byTitle
     */
    private function indexProduct(
        Product $product,
        array &$byStockNumber,
        array &$byBarcode,
        array &$bySlug,
        array &$byTitle
    ): void {
        if ((string) $product->stock_number !== '') {
            $byStockNumber[(string) $product->stock_number] = $product;
        }

        foreach ($this->parseBarcodes($product->barcode ?? '') as $barcode) {
            $byBarcode[$barcode] = $product;
        }

        if ((string) $product->slug !== '') {
            $bySlug[(string) $product->slug] = $product;
        }

        $normalizedTitle = $this->normalizeTitle($product->title);

        if ($normalizedTitle !== '') {
            $byTitle[$normalizedTitle] ??= $product;
        }
    }

    /**
     * @param  array<string, string>  $row
     * @param  array<int, string>  $barcodes
     * @return array<string, mixed>
     */
    private function buildUpdateAttributes(
        Product $product,
        array $row,
        float $price,
        string $stockNumber,
        array $barcodes,
        ?int $categoryId,
        string $description
    ): array {
        $attributes = ['price' => $price];

        if ($stockNumber !== '') {
            $attributes['stock_number'] = $stockNumber;
        }

        if ($barcodes) {
            $attributes['barcode'] = implode(',', $barcodes);
        }

        $this->addNullableAttribute($attributes, 'cost_price', $this->toDecimal($row['costprice'] ?? null));
        $this->addNullableAttribute($attributes, 'tax_rate', $this->cleanValue($row['taxrate'] ?? ''));
        $this->addNullableAttribute($attributes, 'cost_inc_tax', $this->toDecimal($row['costinctax'] ?? null));
        $this->addNullableAttribute($attributes, 'margin_percent', $this->toDecimal($row['marginperc'] ?? null));
        $this->addNullableAttribute($attributes, 'rr_price', $this->toDecimal($row['rrprice'] ?? null));
        $this->addNullableAttribute($attributes, 'bottle_deposit_item_name', $this->cleanValue($row['bottledeposititemname'] ?? ''));
        $this->addNullableAttribute($attributes, 'product_type', $this->cleanValue($row['producttype'] ?? ''));
        $this->addNullableAttribute($attributes, 'size', $this->cleanValue($row['size'] ?? ''));
        $this->addNullableAttribute($attributes, 'colour', $this->cleanValue($row['colour'] ?? ''));
        $this->addNullableAttribute($attributes, 'tare_weight', $this->toDecimal($row['tareweight'] ?? null));
        $this->addNullableAttribute($attributes, 'age_restriction', $this->cleanValue($row['agerestriction'] ?? ''));

        $attributes['is_variable_price'] = $this->toBoolean($row['isvariableprice'] ?? '');
        $attributes['tax_exempt_eligible'] = $this->toBoolean($row['taxexempteligible'] ?? '');

        if ($categoryId !== null) {
            $attributes['category_id'] = $categoryId;
        }

        if ((string) $product->description === '' && $description !== '') {
            $attributes['description'] = $description;
        }

        return $attributes;
    }

    /**
     * @param  array<string, string>  $row
     * @param  array<int, string>  $barcodes
     * @return array<string, mixed>
     */
    private function buildCreateAttributes(
        array $row,
        string $name,
        float $price,
        string $stockNumber,
        array $barcodes,
        ?int $categoryId,
        string $description,
        int $defaultStock
    ): array {
        return [
            'title' => $name,
            'slug' => $this->generateUniqueSlug($name),
            'description' => $description !== '' ? $description : $name,
            'price' => $price,
            'discount' => 0,
            'stock_number' => $stockNumber !== '' ? $stockNumber : null,
            'barcode' => $barcodes ? implode(',', $barcodes) : null,
            'cost_price' => $this->toDecimal($row['costprice'] ?? null),
            'tax_rate' => $this->cleanValue($row['taxrate'] ?? '') ?: null,
            'cost_inc_tax' => $this->toDecimal($row['costinctax'] ?? null),
            'margin_percent' => $this->toDecimal($row['marginperc'] ?? null),
            'rr_price' => $this->toDecimal($row['rrprice'] ?? null),
            'bottle_deposit_item_name' => $this->cleanValue($row['bottledeposititemname'] ?? '') ?: null,
            'product_type' => $this->cleanValue($row['producttype'] ?? '') ?: null,
            'size' => $this->cleanValue($row['size'] ?? '') ?: null,
            'colour' => $this->cleanValue($row['colour'] ?? '') ?: null,
            'tare_weight' => $this->toDecimal($row['tareweight'] ?? null),
            'age_restriction' => $this->cleanValue($row['agerestriction'] ?? '') ?: null,
            'is_variable_price' => $this->toBoolean($row['isvariableprice'] ?? ''),
            'tax_exempt_eligible' => $this->toBoolean($row['taxexempteligible'] ?? ''),
            'category_id' => $categoryId,
            'status' => 1,
            'is_b2b' => 0,
            'availability' => (string) $defaultStock,
        ];
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function addNullableAttribute(array &$attributes, string $key, mixed $value): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $attributes[$key] = $value;
    }

    private function toBoolean(string $value): bool
    {
        $value = strtolower($this->cleanValue($value));

        return in_array($value, ['1', 'true', 'yes', 'y', 'on'], true);
    }

    private function generateUniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'product';
        $slug = $base;
        $suffix = 2;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $suffix++;
        }

        return $slug;
    }
}
