<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check how many products have is_b2b = 1
$count = \App\Models\Product::where('is_b2b', 1)->count();
echo "Products with is_b2b = 1: {$count}\n";

// Get one to verify
$products = \App\Models\Product::whereIn('title', ['Simas Butter', 'Dudu Osun', 'Coconut', 'Delta Soap'])->get();
foreach ($products as $p) {
    echo "Product: {$p->title} | is_b2b: {$p->is_b2b} | price: {$p->price} | discount: {$p->discount}\n";
}
