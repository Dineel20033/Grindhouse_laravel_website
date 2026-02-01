<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin exists
        if (!User::where('email', 'admin@grindhouse.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@grindhouse.com',
                'password' => Hash::make('anupa123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]);
            $this->command->info('Admin user created successfully.');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
