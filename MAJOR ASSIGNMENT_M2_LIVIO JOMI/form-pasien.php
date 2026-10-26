<?php
// ============================================================
// Modul 2 - Form CREATE (tambah) & UPDATE (edit) data pasien
// ============================================================
require 'koneksi.php';

$p = [
    'id' => '', 'no_rm' => '', 'nama' => '', 'nik' => '', 'tgl_lahir' => '',
    'jenis_kelamin' => '', 'gol_darah' => '-', 'no_hp' => '', 'alamat' => '', 'kota' => '',
    'darurat_nama' => '', 'darurat_hubungan' => 'Orang Tua', 'darurat_hp' => '',
];
$modeEdit = false;

// Kalau ada ?id= di URL, berarti mode EDIT: ambil data dari database
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM pasien WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $data = $stmt->fetch();
    if (!$data) {
        header('Location: data-pasien.php');
        exit;
    }
    $p = $data;
    $modeEdit = true;
}

$golongan = ['A', 'B', 'AB', 'O'];
$hubungan = ['Orang Tua', 'Suami/Istri', 'Saudara', 'Anak', 'Lainnya'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $modeEdit ? 'Edit' : 'Tambah' ?> Pasien | Klinik Rawat Jalan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-modul">
        <div class="container">
            <a class="navbar-brand fw-bold" href="data-pasien.php"><i class="bi bi-hospital"></i> Klinik Rawat Jalan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="form-pasien.php"><i class="bi bi-person-plus"></i> Input Pasien</a></li>
                    <li class="nav-item"><a class="nav-link" href="data-pasien.php"><i class="bi bi-table"></i> Data Pasien</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        <div class="page-header mb-4">
            <h2 class="fw-bold mb-1">
                <i class="bi bi-person-vcard"></i> <?= $modeEdit ? 'Edit Data Pasien' : 'Form Pendaftaran Pasien' ?>
            </h2>
            <p class="text-muted mb-0">Modul 2 &mdash; data disimpan ke database MySQL menggunakan PDO.</p>
        </div>

        <form action="simpan.php" method="POST" class="card shadow-sm">
            <input type="hidden" name="id" value="<?= e($p['id']) ?>">
            <div class="card-body p-4">

                <h5 class="section-title">1. Identitas Pasien</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="no_rm" class="form-label">No. Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="no_rm" name="no_rm" placeholder="RM-000123" value="<?= e($p['no_rm']) ?>" required>
                    </div>
                    <div class="col-md-8">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama sesuai KTP" value="<?= e($p['nama']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" maxlength="16" placeholder="16 digit NIK" value="<?= e($p['nik']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= e($p['tgl_lahir']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label d-block">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="Laki-laki" <?= $p['jenis_kelamin'] === 'Laki-laki' ? 'checked' : '' ?> required>
                            <label class="form-check-label" for="jk_l">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="Perempuan" <?= $p['jenis_kelamin'] === 'Perempuan' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="jk_p">Perempuan</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="gol_darah" class="form-label">Golongan Darah</label>
                        <select class="form-select" id="gol_darah" name="gol_darah">
                            <option value="-">-- Pilih --</option>
                            <?php foreach ($golongan as $g): ?>
                                <option <?= $p['gol_darah'] === $g ? 'selected' : '' ?>><?= $g ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="no_hp" name="no_hp" placeholder="08xxxxxxxxxx" value="<?= e($p['no_hp']) ?>" required>
                    </div>
                </div>

                <h5 class="section-title">2. Domisili</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan" required><?= e($p['alamat']) ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="kota" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kota" name="kota" placeholder="Bandung" value="<?= e($p['kota']) ?>" required>
                    </div>
                </div>

                <h5 class="section-title">3. Kontak Darurat</h5>
                <div class="row g-3">
                    <div class="col-md-5">
                        <label for="darurat_nama" class="form-label">Nama Kontak <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="darurat_nama" name="darurat_nama" value="<?= e($p['darurat_nama']) ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="darurat_hubungan" class="form-label">Hubungan</label>
                        <select class="form-select" id="darurat_hubungan" name="darurat_hubungan">
                            <?php foreach ($hubungan as $h): ?>
                                <option <?= $p['darurat_hubungan'] === $h ? 'selected' : '' ?>><?= $h ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="darurat_hp" class="form-label">No. HP Kontak <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="darurat_hp" name="darurat_hp" placeholder="08xxxxxxxxxx" value="<?= e($p['darurat_hp']) ?>" required>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white d-flex justify-content-end gap-2 p-3">
                <a href="data-pasien.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
                <button type="submit" class="btn btn-modul">
                    <i class="bi bi-save"></i> <?= $modeEdit ? 'Simpan Perubahan' : 'Simpan Pasien' ?>
                </button>
            </div>
        </form>
    </main>

    <footer class="text-center text-muted small py-3">
        Modul 2 &mdash; Manajemen Pasien (PHP &amp; MySQL CRUD) &middot; Sistem Informasi Klinik Rawat Jalan
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>