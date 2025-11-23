<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Penitipan;
use Carbon\Carbon;

class PenitipanController extends Controller
{
    public function index(Request $request)
    {
        $show = $request->input('show', 10);
        $sort = $request->input('sort', 'desc');
        $search = $request->input('search');

        $query = Penitipan::query();

        if ($search) {
            $query->where('plat_nomor', 'like', "%{$search}%")
                ->orWhere('merek', 'like', "%{$search}%")
                ->orWhere('warna', 'like', "%{$search}%");
        }

        $penitipan = $query->orderBy('id', $sort)
            ->paginate($show)
            ->appends([
                'show' => $show,
                'sort' => $sort,
                'search' => $search
            ]);

        return view('penitipan.index', compact('penitipan', 'show', 'sort', 'search'));
    }

    public function create()
    {
        return view('penitipan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:20',
            'merek'      => 'nullable|string|max:50',
            'warna'      => 'nullable|string|max:30',
        ]);

        $plat = strtoupper($request->plat_nomor);
        $sudahAda = Penitipan::where('plat_nomor', $plat)
            ->where('status', 'aktif')
            ->exists();

        if ($sudahAda) {
            return redirect()->back()
                ->withErrors(['plat_nomor' => 'Plat nomor ini sudah terdaftar dan masih aktif!'])
                ->withInput();
        }

        Penitipan::create([
            'plat_nomor'    => $plat,
            'merek'         => $request->merek,
            'warna'         => $request->warna,
            'waktu_masuk'   => now(),
            'status'        => 'aktif',
            'kode_struk'    => Str::uuid(),
            'user_id'       => Auth::id(),
        ]);

        return redirect()->route('penitipan.index')
            ->with('success', 'Kendaraan berhasil dititipkan!');
    }

    public function show($id)
    {
        $penitipan = Penitipan::findOrFail($id);
        return view('penitipan.show', compact('penitipan'));
    }

    public function edit($id)
    {
        $penitipan = Penitipan::findOrFail($id);
        return view('penitipan.edit', compact('penitipan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:20',
            'merek' => 'nullable|string|max:50',
            'warna' => 'nullable|string|max:30',
        ]);

        $penitipan = Penitipan::findOrFail($id);

        $plat = strtoupper($request->plat_nomor);
        $duplikat = Penitipan::where('plat_nomor', $plat)
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

        return redirect()->route('penitipan.index')->with('success', 'Data penitipan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $penitipan = Penitipan::findOrFail($id);
        $penitipan->delete();

        return redirect()->route('penitipan.index')->with('success', 'Data penitipan berhasil dihapus!');
    }

    public function keluar($id)
    {
        $penitipan = Penitipan::findOrFail($id);

        $waktuMasuk = Carbon::parse($penitipan->waktu_masuk);
        $waktuKeluar = Carbon::now();
        $durasiHari = $waktuMasuk->diffInDays($waktuKeluar);
        if ($durasiHari == 0) $durasiHari = 1;

        $tarif = 3000;
        $biaya = $durasiHari * $tarif;

        $penitipan->update([
            'waktu_keluar' => $waktuKeluar,
            'total_biaya' => $biaya,
            'status' => 'selesai',
        ]);

        return redirect()->route('penitipan.index')
            ->with('success', 'Kendaraan sudah keluar!');
    }

    public function struk($id)
    {
        $penitipan = Penitipan::findOrFail($id);
        return view('penitipan.struk', compact('penitipan'));
    }
}
