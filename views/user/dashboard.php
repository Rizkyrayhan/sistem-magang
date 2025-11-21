<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/helpers/helper.php';

if (!isPendaftar()) redirect('login');

$user = getCurrentUser();
$pendaftar = getPendaftar($conn, $user['id']);
$evaluasi = $pendaftar ? getEvaluasi($conn, $pendaftar['id']) : null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LEMIGAS Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
        }

        .main-wrapper {
            display: flex;
            gap: 0;
        }

        /* CSS untuk menggeser konten utama (Main Content Area) */
        .main-content-area {
            flex-grow: 1; 
            min-height: 100vh;
            overflow-y: auto;
            transition: margin-left 0.3s ease;
        }
        
        @media (min-width: 1025px) {
            .main-content-area {
                margin-left: 280px; /* Lebar sidebar */
            }
        }

        /* CSS untuk menyembunyikan tombol toggle saat sidebar aktif (mobile) */
        .toggle-sidebar.active {
            display: none !important;
        }

        /* Sisanya tetap sama */
        .header-formal {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e40af 100%);
            border-bottom: 4px solid #3b82f6;
        }

        .stat-card {
            background: white;
            border-left: 4px solid;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        @media (max-width: 640px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <?php $current = 'dashboard'; ?>
        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <div class="main-content-area">
            <div class="toggle-sidebar fixed top-4 left-4 z-50" id="toggleSidebarBtn">
                <button onclick="document.querySelector('.sidebar').classList.toggle('active'); document.getElementById('sidebarOverlay').classList.toggle('active');" 
                        class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg shadow-lg transition">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <div class="header-formal text-white p-6 md:p-8">
                <div class="max-w-6xl mx-auto">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-2">
                        <div>
                            <p class="text-blue-200 text-sm font-semibold">DASHBOARD PESERTA</p>
                            <h1 class="text-3xl md:text-4xl font-bold mt-1">Selamat Datang, <?= htmlspecialchars(explode(' ', $user['nama'])[0]) ?>!</h1>
                        </div>
                        <div class="text-right text-sm">
                            <p class="text-blue-200"><?= date('d M Y') ?></p>
                        </div>
                    </div>
                    <p class="text-blue-100 text-sm md:text-base">Pantau status pendaftaran dan progress magang Anda</p>
                </div>
            </div>

            <div class="p-6 md:p-8 max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="stat-card border-blue-500 shadow-md rounded-lg p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Status Pendaftaran</p>
                                <p class="text-2xl md:text-3xl font-bold text-gray-900 mt-3">
                                    <?php 
                                    $status_map = [
                                        'menunggu' => 'Menunggu',
                                        'diterima' => 'Diterima',
                                        'ditolak' => 'Ditolak',
                                        'proses' => 'Proses',
                                        'selesai' => 'Selesai'
                                    ];
                                    echo $status_map[$pendaftar['status']] ?? ucfirst($pendaftar['status']);
                                    ?>
                                </p>
                            </div>
                            <div class="bg-blue-100 p-4 rounded-lg">
                                <i class="fas fa-user-check text-2xl text-blue-600"></i>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-600">Terakhir diperbarui: <?= formatTanggal($pendaftar['updated_at']) ?></p>
                        </div>
                    </div>

                    <div class="stat-card border-green-500 shadow-md rounded-lg p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Tanggal Daftar</p>
                                <p class="text-lg md:text-2xl font-bold text-gray-900 mt-3">
                                    <?= date('d', strtotime($pendaftar['tanggal_daftar'])) ?>
                                </p>
                                <p class="text-xs text-gray-600 mt-1">
                                    <?= date('F Y', strtotime($pendaftar['tanggal_daftar'])) ?>
                                </p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-lg">
                                <i class="fas fa-calendar-check text-2xl text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card border-purple-500 shadow-md rounded-lg p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Status Evaluasi</p>
                                <p class="text-2xl md:text-3xl font-bold text-gray-900 mt-3">
                                    <?php 
                                    if ($evaluasi && $evaluasi['status'] === 'selesai') {
                                        echo '<span class="text-green-600">Selesai</span>';
                                    } else {
                                        echo '<span class="text-yellow-600">Belum</span>';
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="bg-purple-100 p-4 rounded-lg">
                                <i class="fas fa-chart-bar text-2xl text-purple-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 md:p-8 mb-8 border-t-4 border-blue-600">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-gray-900">Informasi Pendaftaran</h2>
                            <p class="text-sm text-gray-600 mt-1">Data pribadi dan akademik Anda</p>
                        </div>
                        <a href="<?= SITE_URL ?>user/status-pendaftaran" 
                           class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition font-medium text-sm">
                            <i class="fas fa-edit"></i>
                            <span>Edit Data</span>
                        </a>
                    </div>

                    <div class="info-grid">
                        <div>
                            <p class="text-gray-600 text-xs uppercase font-semibold tracking-wide">Nama Lengkap</p>
                            <p class="text-gray-900 font-semibold mt-2"><?= htmlspecialchars($user['nama']) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs uppercase font-semibold tracking-wide">Email</p>
                            <p class="text-gray-900 font-semibold mt-2"><?= htmlspecialchars($user['email']) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs uppercase font-semibold tracking-wide">NIM</p>
                            <p class="text-gray-900 font-semibold mt-2"><?= $pendaftar['nim'] ?: '-' ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs uppercase font-semibold tracking-wide">Universitas</p>
                            <p class="text-gray-900 font-semibold mt-2"><?= $pendaftar['universitas'] ?: '-' ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs uppercase font-semibold tracking-wide">Jurusan</p>
                            <p class="text-gray-900 font-semibold mt-2"><?= $pendaftar['jurusan'] ?: '-' ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs uppercase font-semibold tracking-wide">Bidang Minat</p>
                            <p class="text-gray-900 font-semibold mt-2"><?= $pendaftar['bidang_minat'] ?: '-' ?></p>
                        </div>
                    </div>
                </div>

                <?php if ($evaluasi && $evaluasi['status'] === 'selesai'): ?>
                <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg shadow-md p-6 md:p-8 border-t-4 border-purple-600">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-6">Ringkasan Evaluasi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white rounded-lg p-4 border-l-4 border-blue-500">
                            <p class="text-gray-600 text-xs uppercase font-semibold">Kehadiran</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2"><?= $evaluasi['nilai_kehadiran'] ?></p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: <?= $evaluasi['nilai_kehadiran'] ?>%"></div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 border-l-4 border-green-500">
                            <p class="text-gray-600 text-xs uppercase font-semibold">Kinerja</p>
                            <p class="text-3xl font-bold text-green-600 mt-2"><?= $evaluasi['nilai_kinerja'] ?></p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <div class="bg-green-600 h-2 rounded-full" style="width: <?= $evaluasi['nilai_kinerja'] ?>%"></div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 border-l-4 border-yellow-500">
                            <p class="text-gray-600 text-xs uppercase font-semibold">Sikap</p>
                            <p class="text-3xl font-bold text-yellow-600 mt-2"><?= $evaluasi['nilai_sikap'] ?></p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <div class="bg-yellow-600 h-2 rounded-full" style="width: <?= $evaluasi['nilai_sikap'] ?>%"></div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-4 text-white">
                            <p class="text-purple-100 text-xs uppercase font-semibold">Rata-rata</p>
                            <p class="text-3xl font-bold mt-2"><?= number_format($evaluasi['rata_rata'], 1) ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>