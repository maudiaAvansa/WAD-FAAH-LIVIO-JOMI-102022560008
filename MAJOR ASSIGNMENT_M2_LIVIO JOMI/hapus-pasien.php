<?php
// ============================================================
// Modul A - Manajemen Pasien
// Proses HAPUS data pasien
// ============================================================
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? 0;

    $stmt = $pdo->prepare("DELETE FROM pasien WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: data-pasien.php?dihapus=1');
    exit;
}

// kalau dibuka langsung lewat URL, balikin ke daftar
header('Location: data-pasien.php');
exit;
