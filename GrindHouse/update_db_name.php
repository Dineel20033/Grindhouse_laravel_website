<?php
$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    die(".env file not found\n");
}

$content = file_get_contents($envFile);
$pattern = '/^DB_DATABASE=.*$/m';
$replacement = 'DB_DATABASE=grindhouse_v2';

if (preg_match($pattern, $content)) {
    $content = preg_replace($pattern, $replacement, $content);
    echo "Updated DB_DATABASE to grindhouse_v2.\n";
} else {
    $content .= "\nDB_DATABASE=grindhouse_v2\n";
    echo "Appended DB_DATABASE.\n";
}

file_put_contents($envFile, $content);
echo "Successfully updated .env file.\n";
?>