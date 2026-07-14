<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
try {
    $results = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
    echo "Success! Tables found: " . count($results) . "\n";
} catch (\Exception $e) {
    echo "Failed: " . $e->getMessage() . "\n";
}
