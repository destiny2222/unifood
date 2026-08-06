<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$data = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\ProductImport, 'ProductList.csv');
print_r(array_keys($data[0][0]));
