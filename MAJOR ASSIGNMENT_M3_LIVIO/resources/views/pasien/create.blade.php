@extends('layouts.app')

@section('title', 'Tambah Pasien')

@section('content')
    <div class="page-header mb-4">
        <h2 class="fw-bold mb-1"><i class="bi bi-person-vcard"></i> Form Pendaftaran Pasien</h2>
        <p class="text-muted mb-0">Isi data profil pasien, nomor rekam medis, domisili, dan kontak darurat.</p>
    </div>

    <form action="{{ route('pasien.store') }}" method="POST" class="card shadow-sm">
        @csrf
        @include('pasien._form')
        <div class="card-footer bg-white d-flex justify-content-end gap-2 p-3">
            <a href="{{ route('pasien.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
            <button type="submit" class="btn btn-modul"><i class="bi bi-save"></i> Simpan Pasien</button>
        </div>
    </form>
@endsection