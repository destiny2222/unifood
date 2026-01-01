<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ClearProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all products from database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         if ($this->confirm('Are you sure you want to delete all products?')) {
            Product::truncate();
            $this->info('All products cleared!');
        }
    }
}
