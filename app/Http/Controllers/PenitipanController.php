<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Penitipan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PenitipanController extends Controller
{
    /**
     * Menampilkan daftar penitipan milik user yang login
     */
    public function index(Request $request)
    {
        $show = $request->input('show', 10);
        $sort = $request->input('sort', 'desc');
        $search = $request->input('search');

        $query = Penitipan::own(); // HANYA DATA MILIK USER

        if ($search) {
            $query->where('plat_nomor', 'like', "%{$search}%")
                  ->orWhere('merek', 'like', "%{$search}%")
                  ->orWhere('warna', 'like', "%{$search}%");
        }

        $penitipan = $query->orderBy('id', $sort)
            ->paginate($show)
            ->appends(['show' => $show, 'sort' => $sort, 'search' => $search]);

        return view('penitipan.index', compact('penitipan', 'show', 'sort', 'search'));
    }

    /**
     * Form tambah penitipan
     */
    public function create()
    {
        return view('penitipan.create');
    }

    /**
     * Simpan data penitipan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:20',
            'merek'      => 'nullable|string|max:50',
            'warna'      => 'nullable|string|max:30',
        ]);

        $plat = strtoupper($request->plat_nomor);

        // Cek plat aktif milik user ini saja
        $sudahAda = Penitipan::own()
            ->where('plat_nomor', $plat)
            ->where('status', 'aktif')
            ->exists();

        if ($sudahAda) {
            return redirect()->back()
                ->withErrors(['plat_nomor' => 'Plat nomor ini sudah terdaftar dan masih aktif!'])
                ->withInput();
        }

        Penitipan::create([
            'plat_nomor'  => $plat,
            'merek'       => $request->merek,
            'warna'       => $request->warna,
            'waktu_masuk' => now(),
            'status'      => 'aktif',
            'kode_struk'  => Str::uuid(),
            'user_id'     => Auth::id(), // SIMPAN USER_ID
        ]);

        return redirect()->route('penitipan.index')
            ->with('success', 'Kendaraan berhasil dititipkan!');
    }

    /**
     * Tampilkan detail
     */
    public function show($id)
    {
        $penitipan = Penitipan::own()->findOrFail($id);
        return view('penitipan.show', compact('penitipan'));
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $penitipan = Penitipan::own()->findOrFail($id);
        return view('penitipan.edit', compact('penitipan'));
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:20',
            'merek' => 'nullable|string|max:50',
            'warna' => 'nullable|string|max:30',
        ]);

        $penitipan = Penitipan::own()->findOrFail($id);
        $plat = strtoupper($request->plat_nomor);

        $duplikat = Penitipan::own()
            ->where('plat_nomor', $plat)
            ->where('status', 'aktif')
            ->where('id', '!=', $id)
            ->exists();

        if ($duplikat) {
            return redirect()->back()
                ->withErrors(['plat_nomor' => 'Plat nomor ini sudah digunakan kendaraan aktif lain!'])
                ->withInput();
        }

        $penitipan->update([
            'plat_nomor' => $plat,
            'merek' => $request->merek,
            'warna' => $request->warna,
        ]);

        return redirect()->route('penitipan.index')
            ->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Hapus data
     */
    public function destroy($id)
    {
        $penitipan = Penitipan::own()->findOrFail($id);
        $penitipan->delete();

        return redirect()->route('penitipan.index')
            ->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Proses kendaraan keluar
     */
    public function keluar($id)
    {
        $penitipan = Penitipan::own()->findOrFail($id);

        $waktuMasuk = Carbon::parse($penitipan->waktu_masuk);
        $waktuKeluar = Carbon::now();
        $durasiHari = $waktuMasuk->diffInDays($waktuKeluar);
        if ($durasiHari == 0) $durasiHari = 1;

        $tarif = 3000;
        $biaya = $durasiHari * $tarif;

        $penitipan->update([
            'waktu_keluar' => $waktuKeluar,
            'total_biaya'  => $biaya,
            'status'       => 'selesai',
        ]);

        return redirect()->route('penitipan.index')
            ->with('success', 'Kendaraan sudah keluar!');
    }

    /**
     * Cetak struk
     */
    public function struk($id)
    {
        $penitipan = Penitipan::own()->findOrFail($id);
        return view('penitipan.struk', compact('penitipan'));
    }
}