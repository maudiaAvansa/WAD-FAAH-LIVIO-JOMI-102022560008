<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Data Pasien') | Klinik Rawat Jalan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --warna-utama: #0f766e; --warna-gelap: #115e59; --warna-muda: #ccfbf1; }
        body { background-color: #f1f5f9; font-family: "Segoe UI", system-ui, sans-serif; }
        .navbar-modul { background-color: var(--warna-utama); }
        .page-header { border-left: 5px solid var(--warna-utama); padding-left: 15px; }
        .section-title { color: var(--warna-gelap); font-weight: 600; border-bottom: 2px solid var(--warna-muda); padding-bottom: 6px; margin-bottom: 16px; }
        .btn-modul { background-color: var(--warna-utama); color: #fff; }
        .btn-modul:hover { background-color: var(--warna-gelap); color: #fff; }
        .table-modul th { background-color: var(--warna-utama) !important; color: #fff !important; white-space: nowrap; }
        .badge-modul { background-color: var(--warna-muda); color: var(--warna-gelap); }
        .stat-card { border-top: 4px solid var(--warna-utama); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-modul">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('pasien.index') }}"><i class="bi bi-hospital"></i> Klinik Rawat Jalan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.create') ? 'active' : '' }}" href="{{ route('pasien.create') }}"><i class="bi bi-person-plus"></i> Input Pasien</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.index') ? 'active' : '' }}" href="{{ route('pasien.index') }}"><i class="bi bi-table"></i> Data Pasien</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center text-muted small py-3">
        Modul 3 &mdash; Manajemen Pasien (CRUD Laravel) &middot; Sistem Informasi Klinik Rawat Jalan
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>