@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-1 fs-3">Daftar Penitipan Motor</h3>
        <p class="text-muted mb-3">{{ now()->translatedFormat('d F Y') }}</p>

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
                                <i class="fas fa-plus-circle me-1"></i> Titip
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabel Data --}}
        @if ($penitipan->isEmpty())
            <div class="alert alert-info shadow-sm rounded-3 text-center">Belum ada data penitipan motor.</div>
        @else
            {{-- Filter & Search --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <form method="GET" action="{{ route('penitipan.index') }}" class="d-flex gap-2 align-items-end">
                    <div class="d-flex align-items-center">
                        <label class="me-1 fw-semibold text-muted">Show</label>
                        <select name="show" class="form-select form-select-sm rounded-3 shadow-sm" onchange="this.form.submit()">
                            <option value="10" {{ $show == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $show == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $show == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>

                    <div>
                        <select name="sort" class="form-select form-select-sm rounded-3 shadow-sm" onchange="this.form.submit()">
                            <option value="desc" {{ $sort == 'desc' ? 'selected' : '' }}>Terbaru</option>
                            <option value="asc" {{ $sort == 'asc' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>
                </form>

                {{-- Search modern --}}
                <form method="GET" action="{{ route('penitipan.index') }}" class="w-full max-w-xs">
                    <div class="flex items-center bg-gray-100 rounded-full h-10 px-4 shadow-inner">
                        <svg class="w-4 h-4 text-indigo-600 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                        </svg>

                        <input type="text" name="search" placeholder="Cari" value="{{ request('search') }}"
                            class="w-full bg-transparent focus:outline-none text-indigo-700 placeholder-indigo-400">
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
                                            class="d-inline form-keluar">
                                            @csrf
                                            <button type="button"
                                                class="btn btn-outline-danger btn-sm rounded-circle btn-keluar"
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
                                        class="d-inline form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm rounded-circle btn-hapus" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <script src="https://cdn.tailwindcss.com"></script>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {

                                document.querySelectorAll('.btn-hapus').forEach(btn => {
                                    btn.addEventListener('click', function() {
                                        const form = this.closest('form');

                                        Swal.fire({
                                            title: 'Hapus Data?',
                                            text: 'Data ini akan dihapus permanen.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#6c757d',
                                            confirmButtonText: 'Hapus',
                                            cancelButtonText: 'Batal',
                                            heightAuto: false,
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                Swal.fire({
                                                    title: 'Menghapus...',
                                                    text: 'Harap tunggu sebentar.',
                                                    allowOutsideClick: false,
                                                    allowEscapeKey: false,
                                                    didOpen: () => Swal.showLoading()
                                                });

                                                form.submit();
                                            }
                                        });
                                    });
                                });

                                document.querySelectorAll('.btn-keluar').forEach(btn => {
                                    btn.addEventListener('click', function() {
                                        const form = this.closest('form');

                                        Swal.fire({
                                            title: 'Motor Keluar?',
                                            text: 'Pastikan data sudah benar.',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonColor: '#0d6efd',
                                            cancelButtonColor: '#6c757d',
                                            confirmButtonText: 'Proses',
                                            cancelButtonText: 'Batal',
                                            heightAuto: false,
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                Swal.fire({
                                                    title: 'Memproses...',
                                                    text: 'Sedang menghitung biaya.',
                                                    allowOutsideClick: false,
                                                    allowEscapeKey: false,
                                                    didOpen: () => Swal.showLoading()
                                                });

                                                form.submit();
                                            }
                                        });
                                    });
                                });

                                @if (session('success'))
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: "{{ session('success') }}",
                                        showConfirmButton: false,
                                        timer: 2500,
                                        timerProgressBar: true,
                                    });
                                @endif

                                @if (session('error'))
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'error',
                                        title: "{{ session('error') }}",
                                        showConfirmButton: false,
                                        timer: 2500,
                                        timerProgressBar: true,
                                    });
                                @endif

                            });
                        </script>

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
