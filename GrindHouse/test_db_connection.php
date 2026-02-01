<?php
require __DIR__ . '/vendor/autoload.php';

// Load .env fresh
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "DB_DATABASE from .env: " . $_ENV['DB_DATABASE'] . "\n";
echo "DB_PORT from .env: " . $_ENV['DB_PORT'] . "\n";

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Connected to database: " . DB::connection()->getDatabaseName() . "\n";
?>