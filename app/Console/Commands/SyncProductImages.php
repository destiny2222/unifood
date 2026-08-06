<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Log;

class SyncProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:sync-images {--delete-old : Delete the old product after copying the image}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync images from older existing products to newly imported products with the same name';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Scanning for products without images...");

        // Get all products that do NOT have a main image
        $productsWithoutImages = Product::whereNull('images')->orWhere('images', '')->get();

        $this->info("Found " . $productsWithoutImages->count() . " products without images.");
        
        $syncedCount = 0;

        foreach ($productsWithoutImages as $newProduct) {
            // Find an older product with the exact same title that HAS an image
            // We order by ID ascending to get the oldest one
            $oldProduct = Product::where('title', $newProduct->title)
                                 ->where('id', '!=', $newProduct->id)
                                 ->whereNotNull('images')
                                 ->where('images', '!=', '')
                                 ->orderBy('id', 'asc')
                                 ->first();

            if ($oldProduct) {
                $this->info("Syncing image for: " . $newProduct->title);
                
                // Copy the main image string
                $newProduct->images = $oldProduct->images;
                $newProduct->save();

                // Copy the gallery images if any
                $oldGalleryImages = ProductImage::where('product_id', $oldProduct->id)->get();
                foreach ($oldGalleryImages as $oldGalleryImage) {
                    ProductImage::firstOrCreate([
                        'product_id' => $newProduct->id,
                        'image_path' => $oldGalleryImage->image_path
                    ]);
                }

                $syncedCount++;

                // If user passed --delete-old flag, delete the old product to remove duplicates
                if ($this->option('delete-old')) {
                    $oldProduct->delete();
                    $this->info("  -> Deleted old duplicate product (ID: {$oldProduct->id})");
                }
            }
        }

        $this->info("=== SYNC COMPLETED ===");
        $this->info("Successfully synced images for {$syncedCount} products.");
        return 0;
    }
}
