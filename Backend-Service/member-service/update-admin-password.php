<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Updating admin user password...\n";

$user = User::where('email', 'admin@library.com')->first();
if ($user) {
    $user->password = Hash::make('admin123');
    $user->role = 'admin';
    $user->save();
    echo "✓ Admin password and role updated successfully\n";
    echo "User ID: " . $user->id . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Role: " . $user->role . "\n";
} else {
    echo "✗ Admin user not found\n";
}

echo "\nDone.\n";
