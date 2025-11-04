{{-- resources/views/admin/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-1">Dashboard</h3>
        <p class="text-muted">{{ now()->translatedFormat('d F Y') }}</p>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-users fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-0">Total Pengguna</h6>
                            <h3 class="fw-bold">{{ \App\Models\User::count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-info shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-user-check fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-0">Petugas Aktif</h6>
                            <h3 class="fw-bold">{{ \App\Models\User::where('role', 'petugas')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-2">Panel Admin</h5>
                <p class="text-muted">Kelola data pengguna dari menu <strong>Kelola Pengguna</strong>.</p>
            </div>
        </div>
    </div>
@endsection