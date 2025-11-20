-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Nov 2025 pada 13.57
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lemigas_magang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `evaluasi`
--

CREATE TABLE `evaluasi` (
  `id` int(11) NOT NULL,
  `pendaftar_id` int(11) NOT NULL,
  `nilai_kehadiran` int(11) DEFAULT NULL,
  `nilai_kinerja` int(11) DEFAULT NULL,
  `nilai_sikap` int(11) DEFAULT NULL,
  `rata_rata` decimal(5,2) DEFAULT NULL,
  `status` enum('belum','selesai') NOT NULL DEFAULT 'belum',
  `komentar` text DEFAULT NULL,
  `tanggal_evaluasi` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `evaluasi`
--

INSERT INTO `evaluasi` (`id`, `pendaftar_id`, `nilai_kehadiran`, `nilai_kinerja`, `nilai_sikap`, `rata_rata`, `status`, `komentar`, `tanggal_evaluasi`, `updated_at`, `created_at`) VALUES
(1, 2, 50, 60, 20, 43.33, 'selesai', '', '2024-01-15 01:00:00', '2025-11-19 11:49:40', NULL),
(2, 3, 90, 60, 80, 76.67, 'selesai', 'pinter', '2025-11-19 04:51:46', NULL, '2025-11-19 11:51:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `tempat_tanggal_lahir` varchar(100) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `universitas` varchar(100) DEFAULT NULL,
  `bidang_minat` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `cv_file` varchar(255) DEFAULT NULL,
  `status` enum('menunggu','diterima','ditolak','proses') NOT NULL DEFAULT 'menunggu',
  `tanggal_daftar` timestamp NULL DEFAULT current_timestamp(),
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `surat_pengantar` varchar(255) DEFAULT NULL,
  `ktm_file` varchar(255) DEFAULT NULL,
  `pas_foto` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `semester` tinyint(4) DEFAULT NULL,
  `ipk` decimal(3,2) DEFAULT NULL,
  `durasi_magang` varchar(50) DEFAULT NULL,
  `alasan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pendaftar`
--

INSERT INTO `pendaftar` (`id`, `user_id`, `nim`, `tempat_tanggal_lahir`, `jurusan`, `universitas`, `bidang_minat`, `no_hp`, `alamat`, `cv_file`, `status`, `tanggal_daftar`, `tanggal_mulai`, `tanggal_selesai`, `updated_at`, `surat_pengantar`, `ktm_file`, `pas_foto`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `semester`, `ipk`, `durasi_magang`, `alasan`) VALUES
(1, 2, '2021001234', 'Jakarta, 15 Januari 2001', 'Teknik Informatika', 'Universitas Indonesia', 'Oil & Gas Technology', '081234567890', 'Jl. Merdeka No. 1, Jakarta', NULL, 'ditolak', '2024-01-15 01:00:00', NULL, NULL, '2025-11-19 03:34:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 3, '2021001235', 'Bandung, 20 Februari 2001', 'Sistem Informasi', 'Universitas Padjadjaran', 'Oil & Gas Technology', '082345678901', 'Jl. Riau No. 2, Bandung', NULL, 'diterima', '2024-01-15 01:00:00', NULL, NULL, '2024-01-15 01:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 5, '23312171', 'Lampung, 17 Desember 2004', 'Informatika', 'Universitas Teknokrat Indonesia', 'Oil', '0896745378231', 'jl sutan syahrti', 'storage/uploads/cv/5_cv_1763556716.pdf', 'diterima', '2025-11-18 05:05:12', '2025-11-19', NULL, '2025-11-19 12:51:56', 'storage/uploads/surat/5_surat_1763544098.pdf', 'storage/uploads/ktm/5_ktm_1763544098.jpg', 'storage/uploads/foto/5_foto_1763556702.png', 'Lampung', '2004-12-17', 'Laki-laki', 5, 3.78, '3 bulan', 'karena bagus'),
(4, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'menunggu', '2025-11-19 06:45:29', NULL, NULL, '2025-11-19 06:45:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('admin','pendaftar') NOT NULL DEFAULT 'pendaftar',
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `nama`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin@lemigas.ac.id', '$2y$10$eJ3DO9M9vbYfBTjaX2eOHexu2fHvUF7hOkr4KOJ3NeinOUZACI5Lu', 'Dr. Ahmad Rizki', 'admin', 'aktif', '2024-01-15 01:00:00', '2025-11-18 05:43:58'),
(2, 'siti@mahasiswa.ac.id', '$2y$10$vZ3bR8r9K8mJ7L4Q5X9P2u8N6D3A1E2F7G4H1I8K5L2M9N6Q3R0', 'Siti Nurhaliza', 'pendaftar', 'aktif', '2024-01-15 01:00:00', '2024-01-15 01:00:00'),
(3, 'budi@mahasiswa.ac.id', '$2y$10$w8T1Y4K7M2J9L5Q8X1P4u7N3D6A2E5F1G7H4I9K2L5M8N1Q4R7S', 'Budi Santoso', 'pendaftar', 'aktif', '2024-01-15 01:00:00', '2024-01-15 01:00:00'),
(5, 'rizkyrayhan123@gmail.com', '$2y$10$wZcjPA5zAGbQEkpLDS1GmehA3mmgmVdoM4pANY5V/phGhFuYXPW22', 'Rizky Dwi Rayhan', 'pendaftar', 'aktif', '2025-11-18 05:05:12', '2025-11-18 05:05:12'),
(6, 'admin2@lemigas.ac.id', '$2y$10$9z9K8j7f6g5h4j3k2l1m0n9o8p7q6r5s4t3u2v1w0x9y8z7a6b5c4', 'Budi Santoso S.T., M.T.', 'admin', 'aktif', '2025-11-18 05:41:48', '2025-11-18 05:41:48'),
(7, 'rizkydwirayhan@gmail.com', '$2y$10$sZo4YKWyPeiGcomg6YO/BeBxOJxGSfMLsZ3bA4Lgx4c1Oy5j1VkDC', 'rizky', 'pendaftar', 'aktif', '2025-11-19 06:45:29', '2025-11-19 06:45:29');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `evaluasi`
--
ALTER TABLE `evaluasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_pendaftar_id` (`pendaftar_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_tanggal_evaluasi` (`tanggal_evaluasi`);

--
-- Indeks untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_user_id` (`user_id`),
  ADD UNIQUE KEY `uk_nim` (`nim`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_tanggal_daftar` (`tanggal_daftar`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_email` (`email`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `evaluasi`
--
ALTER TABLE `evaluasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `evaluasi`
--
ALTER TABLE `evaluasi`
  ADD CONSTRAINT `fk_evaluasi_pendaftar_id` FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD CONSTRAINT `fk_pendaftar_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
