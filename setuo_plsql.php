<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::unprepared("DROP FUNCTION IF EXISTS get_donor_name;");
    DB::unprepared("
        CREATE FUNCTION get_donor_name(d_id BIGINT) RETURNS VARCHAR(255)
        DETERMINISTIC
        BEGIN
            DECLARE d_name VARCHAR(255);
            SELECT CONCAT(first_name, ' ', last_name) INTO d_name FROM donor WHERE id = d_id;
            RETURN IFNULL(d_name, 'Donor');
        END;
    ");
    echo "PL/SQL Function created successfully.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
