<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // HAPUS DULU JIKA ADA
        User::where('username', 'admin')->delete();

        // BUAT BARU
        User::create([
            'username' => 'admin',
            'email'    => 'admin@motokeep.com', // PAKSA ISI
            'password' => Hash::make('admin123'),
            'role'     => 'admin', // PAKSA JADI ADMIN
        ]);

        $this->command->info('Akun admin berhasil dibuat: admin / admin123');
    }
}