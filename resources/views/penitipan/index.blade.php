@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-1">Daftar Penitipan Motor</h3>
        <p class="text-muted">{{ now()->translatedFormat('d F Y') }}</p>

        {{-- Form Input Langsung --}}
        <div class="card mb-4 shadow-sm border-0 rounded-4">
            <div class="card-body">
                <form action="{{ route('penitipan.store') }}" method="POST">
                    @csrf
                    <div class="row g-2 align-items-center">
                        <div class="col-md-3">
                            <input type="text" name="plat_nomor"
                                class="form-control rounded-3 @error('plat_nomor') is-invalid @enderror"
                                placeholder="Plat Nomor" required>
                            @error('plat_nomor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="merek" class="form-control rounded-3" placeholder="Merek">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="warna" class="form-control rounded-3" placeholder="Warna">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100 rounded-3">
                                <i class="fas fa-plus-circle me-1"></i> Titip Motor
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Tabel Data --}}
        @if ($penitipan->isEmpty())
            <div class="alert alert-info shadow-sm rounded-3 text-center">Belum ada data penitipan motor.</div>
        @else
            {{-- Filter & Search --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <form method="GET" action="{{ route('penitipan.index') }}" class="d-flex gap-2">
                    <div class="d-flex align-items-center">
                        <label class="me-1 fw-semibold text-muted">Show</label>
                        <select name="show" class="form-select form-select-sm rounded-3" onchange="this.form.submit()">
                            <option value="10" {{ $show == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $show == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $show == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>

                    <div>
                        <select name="sort" class="form-select form-select-sm rounded-3" onchange="this.form.submit()">
                            <option value="desc" {{ $sort == 'desc' ? 'selected' : '' }}>Terbaru</option>
                            <option value="asc" {{ $sort == 'asc' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>
                </form>

                {{-- Search modern --}}
                <form method="GET" action="{{ route('penitipan.index') }}" class="d-flex" style="max-width: 300px;"
                    id="searchForm">
                    <div class="input-group rounded-3 shadow-sm">
                        <input type="text" name="search" class="form-control border-0" placeholder="🔍 Cari..."
                            value="{{ request('search') }}" id="searchInput">
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="table-responsive rounded-4 shadow-sm">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Plat Nomor</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Status</th>
                            <th>Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penitipan as $p)
                            <tr class="text-center" style="background-color: #3f51b5; color: #fff;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->plat_nomor }}</td>
                                <td>{{ $p->waktu_masuk ? \Carbon\Carbon::parse($p->waktu_masuk)->format('d-m-Y H:i') : '-' }}
                                </td>
                                <td>{{ $p->waktu_keluar ? \Carbon\Carbon::parse($p->waktu_keluar)->format('d-m-Y H:i') : '-' }}
                                </td>
                                <td>
                                    @if ($p->status == 'aktif')
                                        <span class="badge bg-warning text-dark rounded-pill">Aktif</span>
                                    @elseif ($p->status == 'selesai')
                                        <span class="badge bg-success rounded-pill">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">Tidak Diketahui</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($p->status == 'selesai' && $p->total_biaya)
                                        Rp {{ number_format($p->total_biaya, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($p->status == 'aktif')
                                        <form action="{{ route('penitipan.keluar', $p->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle"
                                                title="Keluar">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('penitipan.struk', $p->id) }}" target="_blank"
                                            class="btn btn-outline-info btn-sm rounded-circle" title="Cetak Struk">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    @endif

                                    <a href="{{ route('penitipan.show', $p->id) }}"
                                        class="btn btn-outline-primary btn-sm rounded-circle" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('penitipan.edit', $p->id) }}"
                                        class="btn btn-outline-warning btn-sm rounded-circle" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('penitipan.destroy', $p->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Footer Data --}}
            <div class="d-flex justify-content-between mt-3">
                <div class="text-muted small">
                    Menampilkan {{ $penitipan->firstItem() }} - {{ $penitipan->lastItem() }} dari
                    {{ $penitipan->total() }} data
                </div>
                <div>{{ $penitipan->links() }}</div>
            </div>
        @endif
    </div>
@endsection
