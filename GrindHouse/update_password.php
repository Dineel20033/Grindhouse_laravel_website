<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'admin@grindhouse.com')->first();
if ($user) {
    $user->password = Hash::make('anupa123');
    $user->save();
    echo "Password updated successfully for " . $user->email . "\n";
} else {
    echo "Admin user not found.\n";
}
