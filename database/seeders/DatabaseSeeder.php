<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun admin (opsional, jika belum ada)
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );

        // Buat akun user default
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User',
                'password' => Hash::make('user123'),
                'role' => 'user'
            ]
        );
    }
}
