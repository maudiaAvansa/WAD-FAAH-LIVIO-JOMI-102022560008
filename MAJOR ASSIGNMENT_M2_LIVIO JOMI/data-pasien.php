<?php
// ============================================================
// Modul A - Manajemen Pasien
// Halaman 2: DISPLAY data pasien (data diambil dari database)
// ============================================================
require 'koneksi.php';

// Tangkap data dari form (method POST) lalu simpan ke database 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_rm            = trim($_POST['no_rm'] ?? '');
    $nama             = trim($_POST['nama'] ?? '');
    $nik              = trim($_POST['nik'] ?? '');
    $tgl_lahir        = trim($_POST['tgl_lahir'] ?? '');
    $jenis_kelamin    = trim($_POST['jenis_kelamin'] ?? '');
    $gol_darah        = trim($_POST['gol_darah'] ?? '-');
    $no_hp            = trim($_POST['no_hp'] ?? '');
    $alamat           = trim($_POST['alamat'] ?? '');
    $kota             = trim($_POST['kota'] ?? '');
    $darurat_nama     = trim($_POST['darurat_nama'] ?? '');
    $darurat_hubungan = trim($_POST['darurat_hubungan'] ?? '');
    $darurat_hp       = trim($_POST['darurat_hp'] ?? '');

    // cek field yang wajib diisi
    if ($no_rm == '' || $nama == '' || $tgl_lahir == '' || $jenis_kelamin == '' ||
        $no_hp == '' || $alamat == '' || $kota == '' || $darurat_nama == '' || $darurat_hp == '') {
        header('Location: data-pasien.php?error=kosong');
        exit;
    }

    // NIK boleh kosong, tapi kalau diisi harus 16 angka
    if ($nik != '' && !preg_match('/^[0-9]{16}$/', $nik)) {
        header('Location: data-pasien.php?error=nik');
        exit;
    }
    if ($nik == '') {
        $nik = null;
    }

    try {
        $sql = "INSERT INTO pasien (no_rm, nama, nik, tgl_lahir, jenis_kelamin, gol_darah, no_hp,
                                    alamat, kota, darurat_nama, darurat_hubungan, darurat_hp)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$no_rm, $nama, $nik, $tgl_lahir, $jenis_kelamin, $gol_darah, $no_hp,
                        $alamat, $kota, $darurat_nama, $darurat_hubungan, $darurat_hp]);
    } catch (PDOException $ex) {
        // no_rm sudah dipakai (kolom UNIQUE)
        header('Location: data-pasien.php?error=duplikat');
        exit;
    }

    // Redirect supaya data tidak terkirim ulang saat halaman di-refresh
    header('Location: data-pasien.php?sukses=1');
    exit;
}

// Hitung umur dari tanggal lahir
function umur($tgl) {
    if (!$tgl) return '-';
    return (new DateTime($tgl))->diff(new DateTime('today'))->y . ' th';
}

// Ambil semua data pasien dari database
$daftar = $pdo->query("SELECT * FROM pasien ORDER BY id ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien | Klinik Rawat Jalan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-modul">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="bi bi-hospital"></i> Klinik Rawat Jalan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="form-pasien.php"><i class="bi bi-person-plus"></i> Input Pasien</a></li>
                    <li class="nav-item"><a class="nav-link active" href="data-pasien.php"><i class="bi bi-table"></i> Data Pasien</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        <?php if (isset($_GET['ditambah'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> Data pasien berhasil disimpan.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['diubah'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> Data pasien berhasil diubah.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['dihapus'])): ?>
            <div class="alert alert-warning alert-dismissible fade show">
                <i class="bi bi-trash"></i> Data pasien berhasil dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle"></i>
                <?php
                if ($_GET['error'] == 'kosong') {
                    echo 'Data yang wajib diisi belum lengkap.';
                } elseif ($_GET['error'] == 'nik') {
                    echo 'NIK harus 16 digit angka.';
                } elseif ($_GET['error'] == 'duplikat') {
                    echo 'No. Rekam Medis sudah terdaftar.';
                } else {
                    echo 'Terjadi kesalahan.';
                }
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <h2 class="fw-bold mb-1"><i class="bi bi-people"></i> Data Pasien</h2>
                <p class="text-muted mb-0">Modul A &mdash; daftar pasien yang sudah terdaftar.</p>
            </div>
            <a href="form-pasien.php" class="btn btn-modul"><i class="bi bi-plus-lg"></i> Tambah Pasien</a>
        </div>

        <!-- Kartu ringkasan -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card stat-card shadow-sm"><div class="card-body">
                    <div class="text-muted small">Total Pasien</div>
                    <div class="fs-3 fw-bold"><?= count($daftar) ?></div>
                </div></div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm"><div class="card-body">
                    <div class="text-muted small">Laki-laki</div>
                    <div class="fs-3 fw-bold"><?= count(array_filter($daftar, fn($p) => $p['jenis_kelamin'] === 'Laki-laki')) ?></div>
                </div></div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm"><div class="card-body">
                    <div class="text-muted small">Perempuan</div>
                    <div class="fs-3 fw-bold"><?= count(array_filter($daftar, fn($p) => $p['jenis_kelamin'] === 'Perempuan')) ?></div>
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
                            <?php if (empty($daftar)): ?>
                                <tr><td colspan="10" class="text-center text-muted py-4">Belum ada data pasien.</td></tr>
                            <?php endif; ?>
                            <?php foreach ($daftar as $i => $p): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><span class="badge badge-modul"><?= e($p['no_rm']) ?></span></td>
                                    <td>
                                        <div class="fw-semibold"><?= e($p['nama']) ?></div>
                                        <div class="small text-muted">NIK: <?= e($p['nik'] ?: '-') ?></div>
                                    </td>
                                    <td><?= $p['jenis_kelamin'] === 'Laki-laki' ? 'L' : 'P' ?></td>
                                    <td><?= umur($p['tgl_lahir']) ?></td>
                                    <td><?= e($p['gol_darah']) ?></td>
                                    <td><?= e($p['no_hp']) ?></td>
                                    <td>
                                        <div><?= e($p['alamat']) ?></div>
                                        <div class="small text-muted"><?= e($p['kota']) ?></div>
                                    </td>
                                    <td>
                                        <div><?= e($p['darurat_nama']) ?> <span class="small text-muted">(<?= e($p['darurat_hubungan']) ?>)</span></div>
                                        <div class="small text-muted"><?= e($p['darurat_hp']) ?></div>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="edit-pasien.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Edit</a>
                                        <form action="hapus-pasien.php" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus data pasien ini?')">
                                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center text-muted small py-3">
        Modul A &mdash; Manajemen Pasien &middot; Sistem Informasi Klinik Rawat Jalan
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
