<?php
$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    die(".env file not found\n");
}

$content = file_get_contents($envFile);
$pattern = '/^DB_PORT=.*$/m';
$replacement = 'DB_PORT=3307';

if (preg_match($pattern, $content)) {
    $content = preg_replace($pattern, $replacement, $content);
    echo "Updated existing DB_PORT.\n";
} else {
    // Append if not found (though unusual for Laravel .env)
    $content .= "\nDB_PORT=3307\n";
    echo "Appended DB_PORT.\n";
}

file_put_contents($envFile, $content);
echo "Successfully updated .env file.\n";
?>