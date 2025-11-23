<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder {
    public function run(): void {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'username' => 'petugas1',
                'email' => 'petugas1@example.com',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
            ]
        ]);
    }
}

?>