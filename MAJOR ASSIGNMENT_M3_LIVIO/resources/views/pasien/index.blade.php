@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
    <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-people"></i> Data Pasien</h2>
            <p class="text-muted mb-0">Modul 3 &mdash; data pasien dikelola dengan Laravel (MVC + Eloquent).</p>
        </div>
        <a href="{{ route('pasien.create') }}" class="btn btn-modul"><i class="bi bi-plus-lg"></i> Tambah Pasien</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card shadow-sm"><div class="card-body">
                <div class="text-muted small">Total Pasien</div>
                <div class="fs-3 fw-bold">{{ $pasiens->count() }}</div>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card shadow-sm"><div class="card-body">
                <div class="text-muted small">Laki-laki</div>
                <div class="fs-3 fw-bold">{{ $pasiens->where('jenis_kelamin', 'Laki-laki')->count() }}</div>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card shadow-sm"><div class="card-body">
                <div class="text-muted small">Perempuan</div>
                <div class="fs-3 fw-bold">{{ $pasiens->where('jenis_kelamin', 'Perempuan')->count() }}</div>
            </div></div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-modul">
                        <tr>
                            <th>No</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>L/P</th>
                            <th>Umur</th>
                            <th>Gol. Darah</th>
                            <th>No. HP</th>
                            <th>Domisili</th>
                            <th>Kontak Darurat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pasiens as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge badge-modul">{{ $p->no_rm }}</span></td>
                                <td>
                                    <div class="fw-semibold">{{ $p->nama }}</div>
                                    <div class="small text-muted">NIK: {{ $p->nik ?: '-' }}</div>
                                </td>
                                <td>{{ $p->jenis_kelamin === 'Laki-laki' ? 'L' : 'P' }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tgl_lahir)->age }} th</td>
                                <td>{{ $p->gol_darah }}</td>
                                <td>{{ $p->no_hp }}</td>
                                <td>
                                    <div>{{ $p->alamat }}</div>
                                    <div class="small text-muted">{{ $p->kota }}</div>
                                </td>
                                <td>
                                    <div>{{ $p->darurat_nama }} <span class="small text-muted">({{ $p->darurat_hubungan }})</span></div>
                                    <div class="small text-muted">{{ $p->darurat_hp }}</div>
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('pasien.show', $p) }}" class="btn btn-sm btn-outline-secondary" title="Detail"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('pasien.edit', $p) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('pasien.destroy', $p) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus data pasien ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center text-muted py-4">Belum ada data pasien.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection