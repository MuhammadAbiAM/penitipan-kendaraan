<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penitipan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();

        // SEMUA PAKAI own()
        $totalMasuk = Penitipan::own()->whereNotNull('waktu_masuk')->count();
        $totalKeluar = Penitipan::own()->whereNotNull('waktu_keluar')->count();
        $totalPendapatan = Penitipan::own()->sum('total_biaya');
        $totalPendapatanHariIni = Penitipan::own()
            ->whereDate('waktu_keluar', $today)
            ->sum('total_biaya');
        $totalPendapatanBulanIni = Penitipan::own()
            ->whereYear('waktu_keluar', now()->year)
            ->whereMonth('waktu_keluar', now()->month)
            ->sum('total_biaya');

        // Grafik 12 Bulan
        $labels = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->translatedFormat('M Y');

            $data[] = Penitipan::own()
                ->whereYear('waktu_keluar', $month->year)
                ->whereMonth('waktu_keluar', $month->month)
                ->sum('total_biaya');
        }

        return view('laporan.index', compact(
            'totalMasuk', 'totalKeluar', 'totalPendapatan',
            'totalPendapatanHariIni', 'totalPendapatanBulanIni',
            'labels', 'data'
        ));
    }

    public function exportPDF()
    {
        $penitipan = Penitipan::own()->whereNotNull('waktu_keluar')->get();
        $totalPendapatan = $penitipan->sum('total_biaya');

        $pdf = Pdf::loadView('laporan.pdf', compact('penitipan', 'totalPendapatan'));
        return $pdf->download('laporan_penitipan_' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new LaporanExport, 'laporan_penitipan_' . now()->format('Ymd_His') . '.xlsx');
    }
}