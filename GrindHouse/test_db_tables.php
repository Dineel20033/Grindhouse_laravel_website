<?php
// Test database connection and table creation

$host = '127.0.0.1';
$port = 3307;
$username = 'root';
$password = '';
$database = 'SSP2_LARAVEL_GRIND';

try {
    $conn = new mysqli($host, $username, $password, $database, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo "✓ Connected to database: $database\n";

    // Show existing tables
    $result = $conn->query("SHOW TABLES");
    echo "\nExisting tables:\n";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            echo "  - " . $row[0] . "\n";
        }
    } else {
        echo "  (No tables found)\n";
    }

    $conn->close();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
