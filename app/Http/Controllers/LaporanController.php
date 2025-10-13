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
        $today = now()->toDateString();

        $totalMasuk = Penitipan::whereNotNull('waktu_masuk')->count();
        $totalKeluar = Penitipan::whereNotNull('waktu_keluar')->count();
        $totalPendapatan = Penitipan::sum('total_biaya');
        $totalPendapatanHariIni = Penitipan::whereDate('waktu_keluar', $today)->sum('total_biaya');
        $totalPendapatanBulanIni = Penitipan::whereYear('waktu_keluar', now()->year)
            ->whereMonth('waktu_keluar', now()->month)
            ->sum('total_biaya');

        // Data untuk grafik pendapatan bulanan
        $labels = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->format('M Y');

            $data[] = Penitipan::whereYear('waktu_keluar', $month->year)
                ->whereMonth('waktu_keluar', $month->month)
                ->sum('total_biaya');
        }

        return view('laporan.index', compact(
            'totalMasuk',
            'totalKeluar',
            'totalPendapatan',
            'totalPendapatanHariIni',
            'totalPendapatanBulanIni',
            'labels',
            'data'
        ));
    }

    /**
     * Export laporan ke PDF
     */
    public function exportPDF()
    {
        $penitipan = Penitipan::whereNotNull('waktu_keluar')->get();
        $totalPendapatan = $penitipan->sum('total_biaya');

        $pdf = PDF::loadView('laporan.pdf', compact('penitipan', 'totalPendapatan'));
        return $pdf->download('laporan_penitipan_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Export laporan ke Excel
     */
    public function exportExcel()
    {
        return Excel::download(new LaporanExport, 'laporan_penitipan_' . now()->format('Ymd_His') . '.xlsx');
    }
}
