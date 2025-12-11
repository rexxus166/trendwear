<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Developer',
            'email' => 'developer@miomidev.com',
            'password' => Hash::make('password'), // Password default
            'role' => 'admin',
            'status' => 'active',
            'phone' => '081234567890',
            'avatar' => null,
            'email_verified_at' => now(),
        ]);

        // 2. Buat Akun USER BIASA
        User::create([
            'name' => 'Wahyudin',
            'email' => 'wahyudin@miomidev.com',
            'password' => Hash::make('password'), // Password default
            'role' => 'user',
            'status' => 'active',
            'phone' => '089876543210',
            'avatar' => null,
            'email_verified_at' => now(),
        ]);
    }
}
