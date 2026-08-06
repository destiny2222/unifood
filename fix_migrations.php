<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    \Illuminate\Support\Facades\DB::statement('ALTER TABLE users DROP FOREIGN KEY users_kyc_id_foreign;');
    echo "Dropped foreign key users_kyc_id_foreign.\n";
} catch (\Exception $e) {
    echo "Error dropping foreign key: " . $e->getMessage() . "\n";
}

try {
    \Illuminate\Support\Facades\DB::statement('ALTER TABLE users DROP COLUMN kyc_id;');
    echo "Dropped kyc_id from users table manually.\n";
} catch (\Exception $e) {
    echo "Error dropping column: " . $e->getMessage() . "\n";
}
