<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // === ADMIN ===
        User::create([
            'username' => 'admin',
            'email'    => 'admin@motokeep.com',
            'password' => Hash::make('admin123'), // Password: admin123
            'role'     => 'admin',
        ]);

        // === PETUGAS ===
        User::create([
            'username' => 'petugas',
            'email'    => 'petugas@motokeep.com',
            'password' => Hash::make('petugas123'), // Password: petugas123
            'role'     => 'petugas',
        ]);

        // === PETUGAS LAIN (OPSIONAL) ===
        User::create([
            'username' => 'petugas2',
            'email'    => 'petugas2@motokeep.com',
            'password' => Hash::make('123456'),
            'role'     => 'petugas',
        ]);
    }
}