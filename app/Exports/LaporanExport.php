<?php

namespace App\Exports;

use App\Models\Penitipan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Penitipan::own()
            ->select('plat_nomor', 'merek', 'warna', 'waktu_masuk', 'waktu_keluar', 'total_biaya', 'status')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Plat Nomor', 'Merek', 'Warna', 'Waktu Masuk', 'Waktu Keluar', 'Total Biaya', 'Status'
        ];
    }
}