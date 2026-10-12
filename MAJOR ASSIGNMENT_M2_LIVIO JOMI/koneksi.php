<?php
// ============================================================t
// Modul A - Manajemen Pasien
// File koneksi ke database MySQL (PDO)
// ============================================================
$host   = 'localhost';
$dbname = 'klinik_rawat_jalan';
$user   = 'root';
$pass   = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Koneksi gagal: ' . $e->getMessage());
}

// Fungsi bantu: amankan output dari karakter HTML berbahaya
function e($teks) {
    return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
}
