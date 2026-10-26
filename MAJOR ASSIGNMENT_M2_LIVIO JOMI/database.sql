CREATE DATABASE klinik_rawat_jalan;
USE klinik_rawat_jalan;

CREATE TABLE pasien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_rm VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    nik VARCHAR(16),
    tgl_lahir DATE NOT NULL,
    jenis_kelamin ENUM('Laki-laki','Perempuan') NOT NULL,
    gol_darah VARCHAR(3) DEFAULT '-',
    no_hp VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL,
    kota VARCHAR(50) NOT NULL,
    darurat_nama VARCHAR(100) NOT NULL,
    darurat_hubungan VARCHAR(20),
    darurat_hp VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO pasien (no_rm, nama, nik, tgl_lahir, jenis_kelamin, gol_darah, no_hp, alamat, kota, darurat_nama, darurat_hubungan, darurat_hp) VALUES
('RM-000101', 'Siti Rahmawati', '3211014501990002', '1999-01-05', 'Perempuan', 'O', '081234567890', 'Jl. Prabu Geusan Ulun No. 12', 'Sumedang', 'Ahmad Hidayat', 'Suami/Istri', '081298765432'),
('RM-000102', 'Budi Santoso', '3273011203850001', '1985-03-12', 'Laki-laki', 'A', '085711223344', 'Jl. Dago No. 45', 'Bandung', 'Sri Wahyuni', 'Saudara', '085799887766');