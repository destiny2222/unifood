<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$data = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\ProductImport, 'ProductList.csv');
$row = $data[0][0];

$title = $row['name'] ?? ($row['title'] ?? '');
echo "Row name: " . $row['name'] . "\n";
echo "Parsed Title: " . $title . "\n";
