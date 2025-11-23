<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penitipan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();

        $totalMotor = Penitipan::count();
        $motorMasuk = Penitipan::whereDate('waktu_masuk', $today)->count();
        $motorKeluar = Penitipan::whereDate('waktu_keluar', $today)->count();

        // Data Mingguan
        $labelsMinggu = [];
        $dataMasukMinggu = [];
        $dataKeluarMinggu = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->startOfDay();
            $labelsMinggu[] = $day->translatedFormat('l');

            $dataMasukMinggu[] = Penitipan::whereDate('waktu_masuk', $day)->count();
            $dataKeluarMinggu[] = Penitipan::whereDate('waktu_keluar', $day)->count();
        }

        $totalMasukMinggu = array_sum($dataMasukMinggu);
        $totalKeluarMinggu = array_sum($dataKeluarMinggu);

        // Slot
        $totalSlot = 100;
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
