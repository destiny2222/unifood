<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check how many products have is_b2b = 1
$count = \App\Models\Product::where('is_b2b', 1)->count();
echo "Products with is_b2b = 1: {$count}\n";

// Get one to verify
$p = \App\Models\Product::where('is_b2b', 1)->first();
if ($p) {
    echo "Sample Product: ID {$p->id}, Title: '{$p->title}', is_b2b: {$p->is_b2b}\n";
}
