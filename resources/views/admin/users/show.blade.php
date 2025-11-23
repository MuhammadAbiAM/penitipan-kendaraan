@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-1">Detail Pengguna</h3>
        <p class="text-muted">{{ now()->translatedFormat('d F Y') }}</p>

        <div class="card mt-3">
            <div class="card-body">
                <p><strong>Username:</strong> {{ $user->username }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong>
                    <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-info' }} rounded-pill">
                        {{ ucfirst($user->role) }}
                    </span>
                </p>

                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
