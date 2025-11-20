<?php
// config.php - GUARD AGAINST REDECLARE

// Jangan load config 2x
if (defined('CONFIG_LOADED')) {
    return;
}
define('CONFIG_LOADED', true);

// Start session jika belum
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ==================================================================
// ERROR REPORTING (Development = ON, Production = OFF)
// ==================================================================
error_reporting(E_ALL);
ini_set('display_errors', 1); // Ubah jadi 0 di production!

// ==================================================================
// AUTO DETECT SITE_URL
// ==================================================================
if (!defined('SITE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host     = $_SERVER['HTTP_HOST'];
    $dir      = dirname($_SERVER['SCRIPT_NAME']);
    $base     = ($dir === '/' || $dir === '\\') ? '' : rtrim($dir, '/');
    define('SITE_URL', $protocol . $host . $base . '/');
}

define('SITE_NAME', 'LEMIGAS Magang');

// ==================================================================
// TIMEZONE
// ==================================================================
date_default_timezone_set('Asia/Jakarta');

// ==================================================================
// DATABASE CONFIGURATION
// ==================================================================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'lemigas_magang');
define('DB_PORT', 3306);

// ==================================================================
// KONEKSI DATABASE
// ==================================================================
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if ($conn->connect_error) {
    die('Koneksi Database Gagal: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');

// ==================================================================
// BUAT TABEL OTOMATIS JIKA BELUM ADA
// ==================================================================
$sql_users = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('admin','pendaftar') DEFAULT 'pendaftar',
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$sql_pendaftar = "CREATE TABLE IF NOT EXISTS `pendaftar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL UNIQUE,
  `nim` varchar(20),
  `tempat_lahir` varchar(100),
  `tanggal_lahir` date,
  `jenis_kelamin` varchar(20),
  `no_hp` varchar(15),
  `alamat` text,
  `universitas` varchar(100),
  `jurusan` varchar(100),
  `semester` int,
  `ipk` decimal(3,2),
  `bidang_minat` varchar(100),
  `durasi_magang` varchar(50),
  `tanggal_mulai` date,
  `alasan` text,
  `pas_foto` varchar(255),
  `cv_file` varchar(255),
  `surat_pengantar` varchar(255),
  `ktm_file` varchar(255),
  `status` enum('menunggu','diterima','ditolak','proses','selesai') DEFAULT 'menunggu',
  `tanggal_daftar` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$sql_evaluasi = "CREATE TABLE IF NOT EXISTS `evaluasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pendaftar_id` int NOT NULL UNIQUE,
  `nilai_kehadiran` int,
  `nilai_kinerja` int,
  `nilai_sikap` int,
  `rata_rata` decimal(5,2),
  `status` enum('belum','selesai') DEFAULT 'belum',
  `komentar` text,
  `tanggal_evaluasi` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Eksekusi pembuatan tabel
@$conn->query($sql_users);
@$conn->query($sql_pendaftar);
@$conn->query($sql_evaluasi);

// ==================================================================
// INSERT DATA DEMO (hanya jika tabel users masih kosong)
// ==================================================================
$check = $conn->query("SELECT COUNT(*) as count FROM users");
$row   = $check->fetch_assoc();

if ($row['count'] == 0) {
    $pass_admin = password_hash('password', PASSWORD_DEFAULT);
    $pass_siti  = password_hash('password123', PASSWORD_DEFAULT);
    $pass_budi  = password_hash('password456', PASSWORD_DEFAULT);

    $conn->query("INSERT INTO users (email, password, nama, role) VALUES 
        ('admin@lemigas.ac.id', '$pass_admin', 'Dr. Ahmad Rizki', 'admin'),
        ('siti@mahasiswa.ac.id', '$pass_siti', 'Siti Nurhaliza', 'pendaftar'),
        ('budi@mahasiswa.ac.id', '$pass_budi', 'Budi Santoso', 'pendaftar')");

    $conn->query("INSERT INTO pendaftar (user_id, nim, jurusan, universitas, bidang_minat, status) VALUES
        (2, '2021001234', 'Teknik Informatika', 'Universitas Indonesia', 'Oil & Gas', 'menunggu'),
        (3, '2021001235', 'Sistem Informasi', 'Universitas Padjadjaran', 'Oil & Gas', 'diterima')");

    $conn->query("INSERT INTO evaluasi (pendaftar_id, nilai_kehadiran, nilai_kinerja, nilai_sikap, rata_rata, status) VALUES
        (2, 85, 80, 90, 85.00, 'selesai')");
}

// ==================================================================
// CONFIG SELESAI
?>  