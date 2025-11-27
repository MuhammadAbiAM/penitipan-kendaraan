<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Penitipan extends Model
{
    protected $table = 'penitipan';

    public $timestamps = false;

    protected $fillable = [
        'plat_nomor',
        'merek',
        'warna',
        'waktu_masuk',
        'waktu_keluar',
        'total_biaya',
        'status',
    ];
}
