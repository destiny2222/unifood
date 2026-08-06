<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$prods = App\Models\Product::whereNotNull('images')->where('images', '!=', '')->take(5)->get();
echo "Existing products with images:\n";
foreach($prods as $p) {
    echo "ID: {$p->id}, Title: '{$p->title}'\n";
}

$newProds = App\Models\Product::whereNull('images')->orWhere('images', '')->take(5)->get();
echo "\nNewly imported products without images:\n";
foreach($newProds as $p) {
    echo "ID: {$p->id}, Title: '{$p->title}'\n";
}
