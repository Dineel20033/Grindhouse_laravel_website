<?php
// Simple raw migration script

$host = '127.0.0.1';
$port = 3307;
$username = 'root';
$password = '';
$database = 'SSP2_LARAVEL_GRIND';

try {
    // Connect without specifying database first  
    $conn = new mysqli($host, $username, $password, '', $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo "✓ Connected to MySQL\n";

    // Select database
    if (!$conn->select_db($database)) {
        die("✗ Could not select database: " . $conn->error . "\n");
    }

    echo "✓ Selected database: $database\n";

    // Set charset
    $conn->set_charset("utf8mb4");

    echo "✓ Set charset to utf8mb4\n";

    // Get existing tables
    $result = $conn->query("SHOW TABLES");
    $tables = [];
    if ($result) {
        while ($row = $result->fetch_array()) {
            $tables[] = $row[0];
        }
    }

    if (count($tables) > 0) {
        echo "\nExisting tables (" . count($tables) . "):\n";
        foreach ($tables as $table) {
            echo "  - $table\n";
        }
    } else {
        echo "\n✓ Database is empty and ready for migrations\n";
    }

    $conn->close();

    echo "\nNow running Laravel migrations...\n\n";

    // Run artisan migrate
    passthru('php artisan migrate --force 2>&1', $returnCode);

    if ($returnCode === 0) {
        echo "\n✓ Migrations completed successfully!\n";
    } else {
        echo "\n✗ Migration failed with exit code: $returnCode\n";
    }

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
