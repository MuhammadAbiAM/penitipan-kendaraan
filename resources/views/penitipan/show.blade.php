@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Penitipan</h3>

    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Plat Nomor:</strong> {{ $penitipan->plat_nomor }}</p>
            <p><strong>Merek:</strong> {{ $penitipan->merek ?? '-' }}</p>
            <p><strong>Warna:</strong> {{ $penitipan->warna ?? '-' }}</p>
            <p><strong>Waktu Masuk:</strong> {{ $penitipan->waktu_masuk }}</p>
            <p><strong>Waktu Keluar:</strong> {{ $penitipan->waktu_keluar ?? '-' }}</p>
            <p><strong>Status:</strong>
                <span class="badge 
                    {{ $penitipan->status == 'aktif' ? 'bg-success' : ($penitipan->status == 'selesai' ? 'bg-secondary' : 'bg-warning') }}">
                    {{ ucfirst($penitipan->status) }}
                </span>
            </p>
            <p><strong>Total Biaya:</strong> Rp {{ number_format($penitipan->total_biaya, 0, ',', '.') }}</p>

            <a href="{{ route('penitipan.index') }}" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
