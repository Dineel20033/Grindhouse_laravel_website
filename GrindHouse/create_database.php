<?php
// Check MySQL connection and provide feedback

$host = '127.0.0.1';
$port = 3306;
$username = 'root';
$password = '';

echo "Attempting to connect to MySQL at {$host}:{$port}...\n";

try {
    $conn = new mysqli($host, $username, $password, '', $port);

    if ($conn->connect_error) {
        echo "ERROR: Cannot connect to MySQL.\n";
        echo "Error: " . $conn->connect_error . "\n\n";
        echo "Please ensure:\n";
        echo "1. XAMPP is installed\n";
        echo "2. MySQL service is running in XAMPP Control Panel\n";
        echo "3. MySQL is listening on port {$port}\n";
        exit(1);
    }

    echo "✓ Successfully connected to MySQL!\n\n";

    // Create the database
    $dbName = 'SSP2_laravel_grind';
    $sql = "CREATE DATABASE IF NOT EXISTS {$dbName} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

    if ($conn->query($sql) === TRUE) {
        echo "✓ Database '{$dbName}' created successfully or already exists.\n";

        // Check if database exists
        $result = $conn->query("SHOW DATABASES LIKE '{$dbName}'");
        if ($result->num_rows > 0) {
            echo "✓ Confirmed: Database '{$dbName}' is ready.\n";
        }
    } else {
        echo "ERROR: Failed to create database.\n";
        echo "Error: " . $conn->error . "\n";
        exit(1);
    }

    $conn->close();
    echo "\nReady to run migrations!\n";

} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    exit(1);
}
