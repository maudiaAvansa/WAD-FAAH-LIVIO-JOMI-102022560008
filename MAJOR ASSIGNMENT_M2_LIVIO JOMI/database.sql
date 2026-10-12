-- Modul A - Manajemen Pasien
-- Jalankan lewat phpMyAdmin (tab SQL)

CREATE DATABASE IF NOT EXISTS klinik_rawat_jalan;
USE klinik_rawat_jalan;

CREATE TABLE IF NOT EXISTS pasien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_rm VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    nik VARCHAR(16) NULL,
    tgl_lahir DATE NOT NULL,
    jenis_kelamin VARCHAR(10) NOT NULL,
    gol_darah VARCHAR(2) NOT NULL DEFAULT '-',
    no_hp VARCHAR(15) NOT NULL,
    alamat TEXT NOT NULL,
    kota VARCHAR(50) NOT NULL,
    darurat_nama VARCHAR(100) NOT NULL,
    darurat_hubungan VARCHAR(20) NOT NULL,
    darurat_hp VARCHAR(15) NOT NULL
);

INSERT INTO pasien
(no_rm, nama, nik, tgl_lahir, jenis_kelamin, gol_darah, no_hp, alamat, kota, darurat_nama, darurat_hubungan, darurat_hp)
VALUES
('RM-000101', 'Siti Rahmawati', '3211014501990002', '1999-01-05', 'Perempuan', 'O', '081234567890', 'Jl. Prabu Geusan Ulun No. 12', 'Sumedang', 'Ahmad Hidayat', 'Suami/Istri', '081298765432'),
('RM-000102', 'Budi Santoso', '3273011203850001', '1985-03-12', 'Laki-laki', 'A', '085711223344', 'Jl. Dago No. 45', 'Bandung', 'Sri Wahyuni', 'Saudara', '085799887766');
