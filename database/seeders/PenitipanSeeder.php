<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenitipanSeeder extends Seeder {
    public function run(): void {
        DB::table('penitipan')->insert([
            [
                'plat_nomor' => 'R 1234 AB',
                'merek' => 'Honda Beat',
                'warna' => 'Hitam',
                'waktu_masuk' => now()->subHours(3),
                'waktu_keluar' => now(),
                'total_biaya' => 15000,
                'status' => 'selesai',
                'kode_struk' => Str::uuid(),
                'user_id' => 2,
            ],
            [
                'plat_nomor' => 'R 5678 CD',
                'merek' => 'Yamaha NMAX',
                'warna' => 'Putih',
                'waktu_masuk' => now()->subHours(1),
                'waktu_keluar' => null,
                'total_biaya' => null,
                'status' => 'aktif',
                'kode_struk' => Str::uuid(),
                'user_id' => 2,
            ]
        ]);
    }
}
