<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penitipan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now();
        $totalMotor = Penitipan::count();
        $motorMasuk = Penitipan::whereDate('waktu_masuk', $today)->count();
        $motorKeluar = Penitipan::whereDate('waktu_keluar', $today)->count();

        // Data Mingguan
        $labelsMinggu = [];
        $dataMasukMinggu = [];
        $dataKeluarMinggu = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $labelsMinggu[] = $day->translatedFormat('l'); // nama hari

            $dataMasukMinggu[] = Penitipan::whereDate('waktu_masuk', $day)->count();
            $dataKeluarMinggu[] = Penitipan::whereDate('waktu_keluar', $day)->count();
        }

        $totalMasukMinggu = array_sum($dataMasukMinggu);
        $totalKeluarMinggu = array_sum($dataKeluarMinggu);

        // Data Slot Penitipan
        $totalSlot = 300;
        $slotTerisi = Penitipan::where('status', 'aktif')->count();
        $slotTersedia = $totalSlot - $slotTerisi;

        return view('dashboard.index', compact(
            'motorMasuk',
            'motorKeluar',
            'totalMotor',
            'labelsMinggu',
            'dataMasukMinggu',
            'dataKeluarMinggu',
            'totalMasukMinggu',
            'totalKeluarMinggu',
            'totalSlot',
            'slotTerisi',
            'slotTersedia'
        ));
    }
}
