<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$tables = Schema::getTables();
echo "Total tables: " . count($tables) . "\n";
foreach ($tables as $table) {
    echo $table['name'] . "\n";
}
