<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $adminUser = User::create([
            'email' => 'admin@library.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // Create user detail with admin role
        UserDetail::create([
            'id_user' => $adminUser->id,
            'username' => 'admin',
            'name' => 'Admin User',
            'id_role' => 1, // admin role ID
            'telephone_number' => '081234567890',
            'address' => 'Admin Address',
        ]);

        // Create member user for testing
        $memberUser = User::create([
            'email' => 'member@library.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // Create user detail with member role
        UserDetail::create([
            'id_user' => $memberUser->id,
            'username' => 'member',
            'name' => 'Member User',
            'id_role' => 2, // member role ID
            'telephone_number' => '081234567891',
            'address' => 'Member Address',
        ]);
    }
}
