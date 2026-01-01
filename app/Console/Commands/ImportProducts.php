<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from Excel file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file');
        
        // Try different file path approaches
        $possiblePaths = [
            $file,                           // Direct path as provided
            storage_path('app/' . $file),    // Storage app directory
            storage_path($file),             // Storage directory
            public_path($file),              // Public directory
        ];

        $filePath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $filePath = $path;
                break;
            }
        }

        if (!$filePath) {
            $this->error("File not found. Tried these paths:");
            foreach ($possiblePaths as $path) {
                $this->line("  - {$path}");
            }
            return 1;
        }

        $this->info("Found file at: {$filePath}");
        $this->info("File size: " . number_format(filesize($filePath)) . " bytes");
        
        // Count products before import
        $productsBeforeImport = Product::count();
        $categoriesBeforeImport = Category::count();
        
        $this->info("Products in database before import: {$productsBeforeImport}");
        $this->info("Categories in database before import: {$categoriesBeforeImport}");
        
        $this->info("Starting import...");
        Log::info("Starting product import from: {$filePath}");

        try {
            // Clear any previous logs for this import
            Log::info("=== STARTING NEW PRODUCT IMPORT ===");
            
            Excel::import(new ProductImport, $filePath);
            
            // Count products after import
            $productsAfterImport = Product::count();
            $categoriesAfterImport = Category::count();
            
            $productsCreated = $productsAfterImport - $productsBeforeImport;
            $categoriesCreated = $categoriesAfterImport - $categoriesBeforeImport;
            
            $this->info("=== IMPORT COMPLETED ===");
            $this->info("Products created: {$productsCreated}");
            $this->info("Categories created: {$categoriesCreated}");
            $this->info("Total products in database: {$productsAfterImport}");
            $this->info("Total categories in database: {$categoriesAfterImport}");
            
            if ($productsCreated === 0) {
                $this->warn("WARNING: No products were created! Check the logs for details:");
                $this->line("  tail -f storage/logs/laravel.log");
            }
            
            Log::info("Import completed. Products created: {$productsCreated}, Categories created: {$categoriesCreated}");
            
        } catch (\Exception $e) {
            $this->error("Import failed with error: " . $e->getMessage());
            $this->error("File: " . $e->getFile() . " Line: " . $e->getLine());
            
            Log::error("Product import failed: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            
            return 1;
        }

        return 0;
    }
}