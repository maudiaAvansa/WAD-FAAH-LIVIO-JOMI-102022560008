<?php
// ============================================================
// Modul 2 - Proses CREATE (INSERT) & UPDATE data pasien
// ============================================================
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: form-pasien.php');
    exit;
}

$field = ['no_rm', 'nama', 'nik', 'tgl_lahir', 'jenis_kelamin', 'gol_darah',
          'no_hp', 'alamat', 'kota', 'darurat_nama', 'darurat_hubungan', 'darurat_hp'];
$data = [];
foreach ($field as $f) {
    $data[$f] = trim($_POST[$f] ?? '');
}
$id = $_POST['id'] ?? '';

// ---------- Validasi input ----------
$error = [];
$wajib = ['no_rm' => 'No. RM', 'nama' => 'Nama', 'tgl_lahir' => 'Tanggal Lahir',
          'jenis_kelamin' => 'Jenis Kelamin', 'no_hp' => 'No. HP', 'alamat' => 'Alamat',
          'kota' => 'Kota', 'darurat_nama' => 'Nama Kontak Darurat', 'darurat_hp' => 'No. HP Kontak Darurat'];
foreach ($wajib as $kolom => $label) {
    if ($data[$kolom] === '') $error[] = "$label wajib diisi.";
}
if ($data['nik'] !== '' && !preg_match('/^\d{16}$/', $data['nik'])) {
    $error[] = 'NIK harus 16 digit angka.';
}
if ($data['jenis_kelamin'] !== '' && !in_array($data['jenis_kelamin'], ['Laki-laki', 'Perempuan'], true)) {
    $error[] = 'Jenis kelamin tidak valid.';
}
if ($data['nik'] === '') $data['nik'] = null;

// ---------- Simpan ke database ----------
if (!$error) {
    try {
        if ($id === '') {
            $sql = "INSERT INTO pasien (no_rm, nama, nik, tgl_lahir, jenis_kelamin, gol_darah, no_hp,
                        alamat, kota, darurat_nama, darurat_hubungan, darurat_hp)
                    VALUES (:no_rm, :nama, :nik, :tgl_lahir, :jenis_kelamin, :gol_darah, :no_hp,
                        :alamat, :kota, :darurat_nama, :darurat_hubungan, :darurat_hp)";
            $pdo->prepare($sql)->execute($data);
            $pesan = 'tambah';
        } else {
            $sql = "UPDATE pasien SET no_rm = :no_rm, nama = :nama, nik = :nik, tgl_lahir = :tgl_lahir,
                        jenis_kelamin = :jenis_kelamin, gol_darah = :gol_darah, no_hp = :no_hp,
                        alamat = :alamat, kota = :kota, darurat_nama = :darurat_nama,
                        darurat_hubungan = :darurat_hubungan, darurat_hp = :darurat_hp
                    WHERE id = :id";
            $data['id'] = (int) $id;
            $pdo->prepare($sql)->execute($data);
            $pesan = 'edit';
        }
        header("Location: data-pasien.php?pesan=$pesan");
        exit;
    } catch (PDOException $ex) {
        if (($ex->errorInfo[1] ?? null) == 1062) {
            $error[] = 'No. Rekam Medis sudah dipakai pasien lain.';
        } else {
            $error[] = 'Gagal menyimpan data: ' . $ex->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gagal Menyimpan | Klinik Rawat Jalan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <main class="container my-5" style="max-width: 640px;">
        <div class="alert alert-danger">
            <h5 class="fw-bold"><i class="bi bi-exclamation-triangle"></i> Data gagal disimpan</h5>
            <ul class="mb-0">
                <?php foreach ($error as $err): ?>
                    <li><?= e($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <a href="javascript:history.back()" class="btn btn-modul"><i class="bi bi-arrow-left"></i> Kembali ke Form</a>
    </main>
</body>
</html>