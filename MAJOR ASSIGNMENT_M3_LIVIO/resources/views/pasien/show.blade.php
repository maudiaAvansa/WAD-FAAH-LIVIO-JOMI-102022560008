@extends('layouts.app')

@section('title', 'Detail Pasien')

@section('content')
    <a href="{{ route('pasien.index') }}" class="btn btn-light border mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>

    <div class="card shadow-sm">
        <div class="card-header text-white p-4 navbar-modul">
            <h3 class="fw-bold mb-1">{{ $pasien->nama }}</h3>
            <span class="badge bg-light text-dark">{{ $pasien->no_rm }}</span>
        </div>
        <div class="card-body p-4">
            <table class="table mb-0">
                <tr><th style="width: 220px">NIK</th><td>{{ $pasien->nik ?: '-' }}</td></tr>
                <tr><th>Tanggal Lahir</th><td>{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->format('d-m-Y') }} ({{ \Carbon\Carbon::parse($pasien->tgl_lahir)->age }} th)</td></tr>
                <tr><th>Jenis Kelamin</th><td>{{ $pasien->jenis_kelamin }}</td></tr>
                <tr><th>Golongan Darah</th><td>{{ $pasien->gol_darah }}</td></tr>
                <tr><th>No. HP</th><td>{{ $pasien->no_hp }}</td></tr>
                <tr><th>Alamat</th><td>{{ $pasien->alamat }}, {{ $pasien->kota }}</td></tr>
                <tr><th>Kontak Darurat</th><td>{{ $pasien->darurat_nama }} ({{ $pasien->darurat_hubungan }}) &middot; {{ $pasien->darurat_hp }}</td></tr>
                <tr><th>Didaftarkan</th><td>{{ $pasien->created_at->format('d M Y, H:i') }}</td></tr>
            </table>
        </div>
        <div class="card-footer bg-white d-flex gap-2 p-3">
            <a href="{{ route('pasien.edit', $pasien) }}" class="btn btn-modul"><i class="bi bi-pencil"></i> Edit</a>
        </div>
    </div>
@endsection