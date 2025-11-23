{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-1">Daftar Pengguna</h3>
        <p class="text-muted">{{ now()->translatedFormat('d F Y') }}</p>

        {{-- Tabel Data --}}
        @if ($users->count() === 0)
            <div class="alert alert-info shadow-sm rounded-3 text-center">
                Belum ada pengguna.
            </div>
        @else
            <div class="table-responsive rounded-4 shadow-sm">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="text-center">
                                <td>
                                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-info' }} rounded-pill">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="btn btn-outline-warning btn-sm rounded-circle" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
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

            <div class="d-flex justify-content-between mt-3 align-items-center">
                <div class="text-muted small">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} data
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
