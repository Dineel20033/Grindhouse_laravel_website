<?php
// Script to update .env file for MySQL connection

$envFile = __DIR__ . '/.env';
$envExampleFile = __DIR__ . '/.env.example';

// Create .env from .env.example if it doesn't exist
if (!file_exists($envFile) && file_exists($envExampleFile)) {
    copy($envExampleFile, $envFile);
    echo "Created .env file from .env.example\n";
}

if (!file_exists($envFile)) {
    echo "Error: .env file not found\n";
    exit(1);
}

$envContent = file_get_contents($envFile);

// Update database settings
$replacements = [
    '/DB_CONNECTION=.*/m' => 'DB_CONNECTION=mysql',
    '/DB_HOST=.*/m' => 'DB_HOST=127.0.0.1',
    '/DB_PORT=.*/m' => 'DB_PORT=3307',
    '/DB_DATABASE=.*/m' => 'DB_DATABASE=SSP2_LARAVEL_GRIND',
    '/DB_USERNAME=.*/m' => 'DB_USERNAME=root',
    '/DB_PASSWORD=.*/m' => 'DB_PASSWORD=',
];

foreach ($replacements as $pattern => $replacement) {
    if (preg_match($pattern, $envContent)) {
        $envContent = preg_replace($pattern, $replacement, $envContent);
    } else {
        // Add the setting if it doesn't exist
        $envContent .= "\n" . $replacement;
    }
}

file_put_contents($envFile, $envContent);

echo "✓ Updated .env file with MySQL settings:\n";
echo "  - DB_CONNECTION=mysql\n";
echo "  - DB_HOST=127.0.0.1\n";
echo "  - DB_PORT=3307\n";
echo "  - DB_DATABASE=SSP2_LARAVEL_GRIND\n";
echo "  - DB_USERNAME=root\n";
echo "  - DB_PASSWORD=(empty)\n";
