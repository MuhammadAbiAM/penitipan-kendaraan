<?php

namespace Database\Seeders;

use App\Models\Penitipan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyPenitipanSeeder extends Seeder
{
    public function run()
    {
        $petugas = User::where('role', 'petugas')->get();

        foreach ($petugas as $user) {
            for ($i = 1; $i <= 3; $i++) {
                Penitipan::create([
                    'plat_nomor'  => 'B ' . rand(1000, 9999) . ' XYZ',
                    'merek'       => ['Honda', 'Yamaha', 'Suzuki'][array_rand(['Honda', 'Yamaha', 'Suzuki'])],
                    'warna'       => ['Merah', 'Hitam', 'Biru'][array_rand(['Merah', 'Hitam', 'Biru'])],
                    'waktu_masuk' => now()->subDays(rand(1, 5)),
                    'status'      => 'aktif',
                    'kode_struk'  => Str::uuid(),
                    'user_id'     => $user->id,
                ]);
            }
        }

        $this->command->info('Dummy data berhasil!');
    }
}