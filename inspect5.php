<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$counts = \Illuminate\Support\Facades\DB::table('products')
    ->select('title', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
    ->groupBy('title')
    ->having('total', '>', 1)
    ->get();

echo "Duplicates found: " . $counts->count() . "\n";
foreach($counts as $c) {
    echo "Title: '{$c->title}' - Count: {$c->total}\n";
}
