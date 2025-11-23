@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-1">Edit Data Penitipan</h3>

        <form action="{{ route('penitipan.update', $penitipan->id) }}" method="POST" class="mt-3">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Plat Nomor</label>
                <input type="text" name="plat_nomor" class="form-control" value="{{ $penitipan->plat_nomor }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Merek</label>
                <input type="text" name="merek" class="form-control" value="{{ $penitipan->merek }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Warna</label>
                <input type="text" name="warna" class="form-control" value="{{ $penitipan->warna }}">
            </div>

            <a href="{{ route('penitipan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
        </form>
    </div>
@endsection
