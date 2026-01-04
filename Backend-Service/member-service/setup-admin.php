<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;

echo "Setting up admin user properly...\n";

// Get or create admin user
$user = User::where('email', 'admin@library.com')->first();
if (!$user) {
    $user = User::create([
        'name' => 'Administrator',
        'email' => 'admin@library.com',
        'password' => Hash::make('admin123'),
        'email_verified_at' => now(),
    ]);
    echo "✓ Created new admin user\n";
} else {
    $user->password = Hash::make('admin123');
    $user->save();
    echo "✓ Updated existing admin user password\n";
}

// Get admin role
$adminRole = Roles::where('role', 'admin')->first();
if (!$adminRole) {
    $adminRole = Roles::create(['role' => 'admin']);
    echo "✓ Created admin role\n";
} else {
    echo "✓ Admin role exists\n";
}

// Get or create user detail
$userDetail = UserDetail::where('id_user', $user->id)->first();
if (!$userDetail) {
    $userDetail = UserDetail::create([
        'id_user' => $user->id,
        'username' => 'admin',
        'name' => 'Administrator',
        'id_role' => $adminRole->id,
        'telephone_number' => '+1234567890',
        'address' => 'System Administrator'
    ]);
    echo "✓ Created admin user details\n";
} else {
    $userDetail->id_role = $adminRole->id;
    $userDetail->name = 'Administrator';
    $userDetail->username = 'admin';
    $userDetail->save();
    echo "✓ Updated admin user details\n";
}

echo "\nAdmin user setup complete:\n";
echo "User ID: " . $user->id . "\n";
echo "Email: " . $user->email . "\n";
echo "Role: " . $userDetail->roles->role . "\n";
echo "Username: " . $userDetail->username . "\n";

echo "\nDone.\n";
