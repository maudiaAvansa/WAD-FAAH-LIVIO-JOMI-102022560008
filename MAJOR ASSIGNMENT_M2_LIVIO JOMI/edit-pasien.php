<?php
// ============================================================
// Modul A - Manajemen Pasien
// Halaman 3: EDIT data pasien
// ============================================================
require 'koneksi.php';

$error = '';

// Kalau form edit disubmit, update datanya
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id               = $_POST['id'] ?? 0;
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

    if ($no_rm == '' || $nama == '' || $tgl_lahir == '' || $jenis_kelamin == '' ||
        $no_hp == '' || $alamat == '' || $kota == '' || $darurat_nama == '' || $darurat_hp == '') {
        $error = 'Data yang wajib diisi belum lengkap.';
    } elseif ($nik != '' && !preg_match('/^[0-9]{16}$/', $nik)) {
        $error = 'NIK harus 16 digit angka.';
    } else {
        if ($nik == '') {
            $nik = null;
        }

        try {
            $sql = "UPDATE pasien SET no_rm = ?, nama = ?, nik = ?, tgl_lahir = ?, jenis_kelamin = ?,
                                      gol_darah = ?, no_hp = ?, alamat = ?, kota = ?,
                                      darurat_nama = ?, darurat_hubungan = ?, darurat_hp = ?
                    WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$no_rm, $nama, $nik, $tgl_lahir, $jenis_kelamin, $gol_darah, $no_hp,
                            $alamat, $kota, $darurat_nama, $darurat_hubungan, $darurat_hp, $id]);

            header('Location: data-pasien.php?diubah=1');
            exit;
        } catch (PDOException $ex) {
            $error = 'No. Rekam Medis sudah dipakai pasien lain.';
        }
    }

    // kalau ada error, isi form lagi pakai data yang tadi diketik
    $p = [
        'id' => $id, 'no_rm' => $no_rm, 'nama' => $nama, 'nik' => $nik, 'tgl_lahir' => $tgl_lahir,
        'jenis_kelamin' => $jenis_kelamin, 'gol_darah' => $gol_darah, 'no_hp' => $no_hp,
        'alamat' => $alamat, 'kota' => $kota, 'darurat_nama' => $darurat_nama,
        'darurat_hubungan' => $darurat_hubungan, 'darurat_hp' => $darurat_hp,
    ];
} else {
    // Ambil data pasien yang mau diedit
    $id = $_GET['id'] ?? 0;
    $stmt = $pdo->prepare("SELECT * FROM pasien WHERE id = ?");
    $stmt->execute([$id]);
    $p = $stmt->fetch();

    if (!$p) {
        header('Location: data-pasien.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pasien | Klinik Rawat Jalan</title>
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
                    <li class="nav-item"><a class="nav-link" href="data-pasien.php"><i class="bi bi-table"></i> Data Pasien</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        <div class="page-header mb-4">
            <h2 class="fw-bold mb-1"><i class="bi bi-pencil-square"></i> Edit Data Pasien</h2>
            <p class="text-muted mb-0">Modul A &mdash; ubah data pasien yang sudah terdaftar.</p>
        </div>

        <?php if ($error != ''): ?>
            <div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> <?= e($error) ?></div>
        <?php endif; ?>

        <form action="edit-pasien.php" method="POST" class="card shadow-sm">
            <input type="hidden" name="id" value="<?= e($p['id']) ?>">
            <div class="card-body p-4">

                <!-- Bagian 1: Identitas -->
                <h5 class="section-title">1. Identitas Pasien</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="no_rm" class="form-label">No. Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="no_rm" name="no_rm" value="<?= e($p['no_rm']) ?>" required>
                    </div>
                    <div class="col-md-8">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= e($p['nama']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" maxlength="16" value="<?= e($p['nik']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= e($p['tgl_lahir']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label d-block">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="Laki-laki" <?= $p['jenis_kelamin'] == 'Laki-laki' ? 'checked' : '' ?> required>
                            <label class="form-check-label" for="jk_l">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="Perempuan" <?= $p['jenis_kelamin'] == 'Perempuan' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="jk_p">Perempuan</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="gol_darah" class="form-label">Golongan Darah</label>
                        <select class="form-select" id="gol_darah" name="gol_darah">
                            <option value="-" <?= $p['gol_darah'] == '-' ? 'selected' : '' ?>>-- Pilih --</option>
                            <option <?= $p['gol_darah'] == 'A' ? 'selected' : '' ?>>A</option>
                            <option <?= $p['gol_darah'] == 'B' ? 'selected' : '' ?>>B</option>
                            <option <?= $p['gol_darah'] == 'AB' ? 'selected' : '' ?>>AB</option>
                            <option <?= $p['gol_darah'] == 'O' ? 'selected' : '' ?>>O</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="no_hp" name="no_hp" value="<?= e($p['no_hp']) ?>" required>
                    </div>
                </div>

                <!-- Bagian 2: Domisili -->
                <h5 class="section-title">2. Domisili</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required><?= e($p['alamat']) ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="kota" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kota" name="kota" value="<?= e($p['kota']) ?>" required>
                    </div>
                </div>

                <!-- Bagian 3: Kontak Darurat -->
                <h5 class="section-title">3. Kontak Darurat</h5>
                <div class="row g-3">
                    <div class="col-md-5">
                        <label for="darurat_nama" class="form-label">Nama Kontak <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="darurat_nama" name="darurat_nama" value="<?= e($p['darurat_nama']) ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="darurat_hubungan" class="form-label">Hubungan</label>
                        <select class="form-select" id="darurat_hubungan" name="darurat_hubungan">
                            <option <?= $p['darurat_hubungan'] == 'Orang Tua' ? 'selected' : '' ?>>Orang Tua</option>
                            <option <?= $p['darurat_hubungan'] == 'Suami/Istri' ? 'selected' : '' ?>>Suami/Istri</option>
                            <option <?= $p['darurat_hubungan'] == 'Saudara' ? 'selected' : '' ?>>Saudara</option>
                            <option <?= $p['darurat_hubungan'] == 'Anak' ? 'selected' : '' ?>>Anak</option>
                            <option <?= $p['darurat_hubungan'] == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="darurat_hp" class="form-label">No. HP Kontak <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="darurat_hp" name="darurat_hp" value="<?= e($p['darurat_hp']) ?>" required>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white d-flex justify-content-end gap-2 p-3">
                <a href="data-pasien.php" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i> Batal</a>
                <button type="submit" class="btn btn-modul"><i class="bi bi-save"></i> Simpan Perubahan</button>
            </div>
        </form>
    </main>

    <footer class="text-center text-muted small py-3">
        Modul A &mdash; Manajemen Pasien &middot; Sistem Informasi Klinik Rawat Jalan
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
