<?php
// views/admin/detail-pendaftar.php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/helpers/helper.php';

// Proteksi: Harus login + harus admin
if (!isLoggedIn() || !isAdmin()) {
    redirect('login');
    exit;
}

// Ambil ID dari parameter URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    redirect('admin/data-pendaftar');
    exit;
}

// Ambil data pendaftar berdasarkan ID
$pendaftar = $conn->query("
    SELECT p.*, u.nama, u.email 
    FROM pendaftar p 
    JOIN users u ON p.user_id = u.id 
    WHERE p.id = $id 
    LIMIT 1
");

if (!$pendaftar || $pendaftar->num_rows === 0) {
    redirect('admin/data-pendaftar');
    exit;
}

$p = $pendaftar->fetch_assoc();
$current = 'data-pendaftar';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pendaftar - LEMIGAS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-white">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include 'partials/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-white border-b border-gray-200 sticky top-0 z-20">
                <div class="flex items-center justify-between px-4 md:px-8 py-4 md:py-6">
                    <div class="flex items-center space-x-4">
                        <button id="sidebarToggle" class="md:hidden p-2 hover:bg-gray-100 rounded-lg transition text-gray-700">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                        
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Detail Pendaftar</h1>
                            <p class="text-xs md:text-sm text-gray-600 hidden md:block">Informasi lengkap tentang pendaftar magang</p>
                        </div>
                    </div>

                    <a href="<?= SITE_URL ?>admin/data-pendaftar" class="hidden md:inline-block text-blue-600 hover:text-blue-800 font-medium text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-4 md:p-8">
                    <!-- Kembali Button Mobile -->
                    <a href="<?= SITE_URL ?>admin/data-pendaftar" class="md:hidden inline-flex items-center text-blue-600 hover:text-blue-800 text-sm mb-4">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>

                    <!-- Content -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <!-- Card Info -->
                        <div class="p-4 md:p-8 border-b border-gray-200">
                            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6">
                                <div class="flex-shrink-0">
                                    <?php if ($p['pas_foto']): ?>
                                        <img src="<?= file_url($p['pas_foto']) ?>" 
                                             alt="<?= htmlspecialchars($p['nama']) ?>"
                                             class="w-20 h-24 md:w-32 md:h-40 rounded-lg object-cover">
                                    <?php else: ?>
                                        <div class="w-20 h-24 md:w-32 md:h-40 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center text-white text-3xl md:text-5xl font-bold">
                                            <?= strtoupper(substr($p['nama'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 truncate"><?= htmlspecialchars($p['nama']) ?></h2>
                                    <p class="text-sm md:text-lg text-gray-600 mt-1 truncate"><?= htmlspecialchars($p['email']) ?></p>
                                    <div class="mt-3 md:mt-4">
                                        <?= getBadgeStatus($p['status']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Pribadi -->
                        <div class="p-4 md:p-8 border-b border-gray-200">
                            <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-4">Data Pribadi</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Tempat Lahir</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['tempat_lahir'] ?: '-') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Tanggal Lahir</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= formatTanggal($p['tanggal_lahir']) ?></p>
                                </div>
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Jenis Kelamin</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['jenis_kelamin'] ?: '-') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">No. HP</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['no_hp'] ?: '-') ?></p>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-6">
                                <p class="text-xs md:text-sm text-gray-600">Alamat Lengkap</p>
                                <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['alamat'] ?: '-') ?></p>
                            </div>
                        </div>

                        <!-- Data Akademik -->
                        <div class="p-4 md:p-8 border-b border-gray-200">
                            <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-4">Data Akademik</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Universitas</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['universitas'] ?: '-') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Jurusan</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['jurusan'] ?: '-') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">NIM</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['nim'] ?: '-') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Semester</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['semester'] ?: '-') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">IPK</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['ipk'] ?: '-') ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Data Magang -->
                        <div class="p-4 md:p-8 border-b border-gray-200">
                            <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-4">Informasi Magang</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Bidang Minat</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['bidang_minat'] ?: '-') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Durasi</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['durasi_magang'] ?: '-') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Tanggal Mulai</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= formatTanggal($p['tanggal_mulai']) ?></p>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-6">
                                <p class="text-xs md:text-sm text-gray-600">Alasan Mendaftar</p>
                                <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['alasan'] ?: '-') ?></p>
                            </div>
                        </div>

                        <!-- Dokumen -->
                        <div class="p-4 md:p-8 border-b border-gray-200">
                            <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-4">Dokumen Pendukung</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div class="text-center p-4 border border-gray-200 rounded-lg">
                                    <p class="font-semibold text-gray-900 mb-3 text-sm md:text-base">CV</p>
                                    <?php if ($p['cv_file']): ?>
                                        <a href="<?= file_url($p['cv_file']) ?>" target="_blank" class="inline-block">
                                            <i class="fas fa-file-pdf text-4xl md:text-5xl text-red-600 mb-2"></i>
                                            <p class="text-sm text-blue-600 hover:underline">Download</p>
                                        </a>
                                    <?php else: ?>
                                        <i class="fas fa-file-pdf text-4xl md:text-5xl text-gray-300 mb-2"></i>
                                        <p class="text-xs md:text-sm text-gray-500">Belum upload</p>
                                    <?php endif; ?>
                                </div>

                                <div class="text-center p-4 border border-gray-200 rounded-lg">
                                    <p class="font-semibold text-gray-900 mb-3 text-sm md:text-base">Surat Pengantar</p>
                                    <?php if ($p['surat_pengantar']): ?>
                                        <a href="<?= file_url($p['surat_pengantar']) ?>" target="_blank" class="inline-block">
                                            <i class="fas fa-envelope-open-text text-4xl md:text-5xl text-blue-600 mb-2"></i>
                                            <p class="text-sm text-blue-600 hover:underline">Download</p>
                                        </a>
                                    <?php else: ?>
                                        <i class="fas fa-envelope-open-text text-4xl md:text-5xl text-gray-300 mb-2"></i>
                                        <p class="text-xs md:text-sm text-gray-500">Belum upload</p>
                                    <?php endif; ?>
                                </div>

                                <div class="text-center p-4 border border-gray-200 rounded-lg">
                                    <p class="font-semibold text-gray-900 mb-3 text-sm md:text-base">KTM</p>
                                    <?php if ($p['ktm_file']): ?>
                                        <a href="<?= file_url($p['ktm_file']) ?>" target="_blank" class="inline-block">
                                            <i class="fas fa-id-card text-4xl md:text-5xl text-green-600 mb-2"></i>
                                            <p class="text-sm text-blue-600 hover:underline">Lihat</p>
                                        </a>
                                    <?php else: ?>
                                        <i class="fas fa-id-card text-4xl md:text-5xl text-gray-300 mb-2"></i>
                                        <p class="text-xs md:text-sm text-gray-500">Belum upload</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Meta -->
                        <div class="p-4 md:p-8 bg-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Tanggal Daftar</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= formatTanggalFull($p['tanggal_daftar']) ?></p>
                                </div>
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Status Terakhir</p>
                                    <p class="font-semibold text-gray-900 text-sm md:text-base"><?= htmlspecialchars($p['status']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>