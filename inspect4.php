<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$p = App\Models\Product::find(6);
echo "ID: {$p->id}\n";
echo "Title: {$p->title}\n";
echo "Price: {$p->price}\n";
echo "Image: {$p->images}\n";

$duplicates = App\Models\Product::where('title', 'Ayoola Cassava fufu 900g')->get();
echo "\nTotal products with this title: " . $duplicates->count() . "\n";
foreach($duplicates as $d) {
    echo "ID: {$d->id}, Slug: {$d->slug}, Price: {$d->price}, HasImage: " . (!empty($d->images) ? 'Yes' : 'No') . "\n";
}
