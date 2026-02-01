<?php
// Direct migration runner with detailed error output

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

try {
    // Test database connection first
    echo "Testing database connection...\n";
    $pdo = new PDO(
        "mysql:host=127.0.0.1;port=3307;dbname=SSP2_LARAVEL_GRIND",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✓ Database connection successful\n\n";

    // Run migration command
    echo "Running migrations...\n";
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    $status = $kernel->call('migrate', [
        '--force' => true,
        '--verbose' => 3
    ]);

    echo "\nMigration exit code: $status\n";
    echo $kernel->output();

} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    echo "Error code: " . $e->getCode() . "\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
