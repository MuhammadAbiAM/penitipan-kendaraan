<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penitipan extends Model
{
    protected $table = 'penitipan';
    protected $fillable = [
        'plat_nomor',
        'merek',
        'warna',
        'waktu_masuk',
        'waktu_keluar',
        'tarif_per_hari',
        'total_biaya',
        'status',
        'kode_struk',
    ];

    protected $dates = ['waktu_masuk', 'waktu_keluar'];

    public $timestamps = false;

    // public function kendaraan()
    // {
    //     return $this->belongsTo(Kendaraan::class);
    // }

    // public function transaksi()
    // {
    //     return $this->hasOne(Transaksi::class);
    // }
}
