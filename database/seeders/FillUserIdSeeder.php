<?php

namespace Database\Seeders;

use App\Models\Penitipan;
use App\Models\User;
use Illuminate\Database\Seeder;

class FillUserIdSeeder extends Seeder
{
    public function run()
    {
        $petugasIds = User::where('role', 'petugas')->pluck('id')->toArray();

        if (empty($petugasIds)) {
            $this->command->error('Tidak ada petugas!');
            return;
        }

        $dataTanpaUser = Penitipan::whereNull('user_id')->get();

        foreach ($dataTanpaUser as $item) {
            $item->user_id = $petugasIds[array_rand($petugasIds)];
            $item->saveQuietly(); // TANPA UPDATE updated_at
        }

        $this->command->info('Berhasil isi ' . $dataTanpaUser->count() . ' data!');
    }
}