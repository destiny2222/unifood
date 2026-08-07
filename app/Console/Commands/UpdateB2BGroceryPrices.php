<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class UpdateB2BGroceryPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'b2b:update-grocery-prices {file=ProductList0.1.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update B2B product prices for Grocery/Groceries from a CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = base_path($this->argument('file'));

        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            $this->error("Could not open file: {$filePath}");
            return 1;
        }

        $header = fgetcsv($handle);
        $updatedCount = 0;
        $notFoundCount = 0;

        $this->info("Processing CSV file...");

        while (($data = fgetcsv($handle)) !== false) {
            if (empty($data[0])) {
                continue;
            }

            $name = trim($data[0]);
            $description = trim($data[1] ?? '');
            $price = (float) trim($data[2] ?? 0);

            if ($price <= 0) {
                continue;
            }

            // Find matching product
            $product = Product::where('title', $name)->first();

            if (!$product) {
                // Try stripping parenthetical text e.g. "honey 4kg (Box)" -> "honey 4kg"
                $cleanName = trim(preg_replace('/\s*\(.*?\)/', '', $name));
                $product = Product::where('title', $cleanName)->first();
            }

            if (!$product) {
                // Try LIKE search
                $product = Product::where('title', 'like', '%' . $name . '%')->first();
            }

            if (!$product) {
                // Try slug match
                $slug = \Str::slug($name);
                $product = Product::where('slug', $slug)->first();
            }

            if ($product) {
                $oldPrice = $product->price;
                $product->price = $price;
                $product->is_b2b = 1; // Ensure B2B flag is set

                if (!empty($description) && empty($product->description)) {
                    $product->description = $description;
                }

                $product->save();
                $updatedCount++;

                $this->line("Updated: '{$product->title}' (ID: {$product->id}) - Old: £{$oldPrice} => New B2B: £{$price}");
            } else {
                $notFoundCount++;
                $this->warn("Not Found: '{$name}'");
            }
        }

        fclose($handle);

        $this->info("\nDone! Successfully updated {$updatedCount} B2B products. (Not found: {$notFoundCount})");

        return 0;
    }
}
