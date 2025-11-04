<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FixUserPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id'       => 13,
                'username' => 'Dewi',
                'password' => 'dewi123',
                'email'    => 'dewi@motokeep.com',
                'role'     => 'petugas',
            ],
            [
                'id'       => 14,
                'username' => 'Danil',
                'password' => 'danil123',
                'email'    => 'danil@motokeep.com',
                'role'     => 'petugas',
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['id' => $data['id']], // Cari berdasarkan ID
                [
                    'username' => $data['username'],
                    'email'    => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role'     => $data['role'],
                ]
            );
        }

        $this->command->info('Password berhasil di-set untuk Dewi dan Danil!');
    }
}