@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-1">Detail Penitipan</h3>
        <p class="text-muted">{{ now()->translatedFormat('d F Y') }}</p>

        <div class="card mt-3">
            <div class="card-body">
                <p><strong>Plat Nomor:</strong> {{ $penitipan->plat_nomor }}</p>
                <p><strong>Merek:</strong> {{ $penitipan->merek ?? '-' }}</p>
                <p><strong>Warna:</strong> {{ $penitipan->warna ?? '-' }}</p>
                <p><strong>Waktu Masuk:</strong>
                    {{ $penitipan->waktu_masuk ? \Carbon\Carbon::parse($penitipan->waktu_masuk)->format('d-m-Y H:i') : '-' }}
                </p>
                <p><strong>Waktu Keluar:</strong>
                    {{ $penitipan->waktu_keluar ? \Carbon\Carbon::parse($penitipan->waktu_keluar)->format('d-m-Y H:i') : '-' }}
                </p>
                <p><strong>Status:</strong>
                    <span
                        class="badge 
                    {{ $penitipan->status == 'aktif' ? 'bg-warning text-dark' : ($penitipan->status == 'selesai' ? 'bg-success' : 'bg-secondary') }}">
                        {{ ucfirst($penitipan->status) }}
                    </span>
                </p>
                <p><strong>Total Biaya:</strong>
                    @if ($penitipan->status == 'selesai' && $penitipan->total_biaya)
                        Rp {{ number_format($penitipan->total_biaya, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </p>

                <a href="{{ route('penitipan.index') }}" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
