@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('content')
    <div class="page-header mb-4">
        <h2 class="fw-bold mb-1"><i class="bi bi-pencil-square"></i> Edit Data Pasien</h2>
        <p class="text-muted mb-0">Ubah data pasien {{ $pasien->nama }} ({{ $pasien->no_rm }}).</p>
    </div>

    <form action="{{ route('pasien.update', $pasien) }}" method="POST" class="card shadow-sm">
        @csrf
        @method('PUT')
        @include('pasien._form')
        <div class="card-footer bg-white d-flex justify-content-end gap-2 p-3">
            <a href="{{ route('pasien.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
            <button type="submit" class="btn btn-modul"><i class="bi bi-save"></i> Simpan Perubahan</button>
        </div>
    </form>
@endsection