<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/helpers/helper.php';

if (!isLoggedIn() || !isPendaftar()) {
    redirect('login');
}

$user = getCurrentUser();
$pendaftar = getPendaftar($conn, $user['id']);
$evaluasi = $pendaftar ? getEvaluasi($conn, $pendaftar['id']) : null;
$current = 'evaluasi';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Evaluasi - LEMIGAS Magang</title>
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

        .score-circle {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto;
        }

        .score-circle svg {
            transform: rotate(-90deg);
        }

        .score-value {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .stat-badge {
            border-left: 4px solid;
            transition: all 0.3s ease;
        }

        .stat-badge:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }

        .interpretation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        @media (max-width: 640px) {
            .interpretation-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
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
                    <div class="flex items-center gap-4 mb-3">
                        <div class="bg-blue-400 bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-star text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-blue-100 text-sm font-semibold">HASIL PENILAIAN</p>
                            <h1 class="text-2xl md:text-3xl font-bold">Hasil Evaluasi Magang</h1>
                        </div>
                    </div>
                    <p class="text-blue-100 text-sm">Lihat hasil evaluasi dan penilaian magang Anda</p>
                </div>
            </div>

            <div class="max-w-5xl mx-auto px-4 md:px-8 py-8">
                <?php if (!$evaluasi || $evaluasi['status'] !== 'selesai'): ?>
                    <div class="bg-white rounded-lg shadow-md p-12 text-center border-t-4 border-yellow-500">
                        <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-hourglass-half text-3xl text-yellow-600"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Evaluasi Belum Tersedia</h2>
                        <p class="text-gray-600 text-lg mb-4">Evaluasi Anda sedang dalam proses penilaian oleh mentor</p>
                        <p class="text-gray-500 text-sm">Silakan kembali lagi nanti untuk melihat hasil evaluasi Anda</p>
                    </div>

                <?php else: ?>
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg shadow-md p-6 md:p-8 mb-8 border-l-4 border-blue-600">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <p class="text-gray-600 text-xs uppercase font-semibold">Nama Peserta</p>
                                <p class="text-xl font-bold text-gray-900 mt-2"><?= htmlspecialchars($user['nama']) ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs uppercase font-semibold">NIM</p>
                                <p class="text-xl font-bold text-gray-900 mt-2"><?= $pendaftar['nim'] ?: '-' ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs uppercase font-semibold">Tanggal Evaluasi</p>
                                <p class="text-xl font-bold text-gray-900 mt-2"><?= formatTanggal($evaluasi['tanggal_evaluasi']) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="stat-badge border-blue-500 bg-white rounded-lg shadow-md p-6 text-center">
                            <p class="text-gray-600 text-xs uppercase font-semibold mb-4">Nilai Kehadiran</p>
                            <div class="score-circle">
                                <svg width="140" height="140" class="w-full h-full">
                                    <circle cx="70" cy="70" r="65" fill="none" stroke="#e5e7eb" stroke-width="6"/>
                                    <circle cx="70" cy="70" r="65" fill="none" stroke="#3b82f6" stroke-width="6" 
                                            stroke-dasharray="<?php echo (408.41 * $evaluasi['nilai_kehadiran'] / 100); ?>" 
                                            stroke-dashoffset="0" stroke-linecap="round"/>
                                </svg>
                                <div class="score-value">
                                    <span class="text-3xl font-bold text-blue-600"><?= $evaluasi['nilai_kehadiran'] ?></span>
                                    <span class="text-xs text-gray-600">dari 100</span>
                                </div>
                            </div>
                        </div>

                        <div class="stat-badge border-green-500 bg-white rounded-lg shadow-md p-6 text-center">
                            <p class="text-gray-600 text-xs uppercase font-semibold mb-4">Nilai Kinerja</p>
                            <div class="score-circle">
                                <svg width="140" height="140" class="w-full h-full">
                                    <circle cx="70" cy="70" r="65" fill="none" stroke="#e5e7eb" stroke-width="6"/>
                                    <circle cx="70" cy="70" r="65" fill="none" stroke="#10b981" stroke-width="6" 
                                            stroke-dasharray="<?php echo (408.41 * $evaluasi['nilai_kinerja'] / 100); ?>" 
                                            stroke-dashoffset="0" stroke-linecap="round"/>
                                </svg>
                                <div class="score-value">
                                    <span class="text-3xl font-bold text-green-600"><?= $evaluasi['nilai_kinerja'] ?></span>
                                    <span class="text-xs text-gray-600">dari 100</span>
                                </div>
                            </div>
                        </div>

                        <div class="stat-badge border-yellow-500 bg-white rounded-lg shadow-md p-6 text-center">
                            <p class="text-gray-600 text-xs uppercase font-semibold mb-4">Nilai Sikap</p>
                            <div class="score-circle">
                                <svg width="140" height="140" class="w-full h-full">
                                    <circle cx="70" cy="70" r="65" fill="none" stroke="#e5e7eb" stroke-width="6"/>
                                    <circle cx="70" cy="70" r="65" fill="none" stroke="#f59e0b" stroke-width="6" 
                                            stroke-dasharray="<?php echo (408.41 * $evaluasi['nilai_sikap'] / 100); ?>" 
                                            stroke-dashoffset="0" stroke-linecap="round"/>
                                </svg>
                                <div class="score-value">
                                    <span class="text-3xl font-bold text-yellow-600"><?= $evaluasi['nilai_sikap'] ?></span>
                                    <span class="text-xs text-gray-600">dari 100</span>
                                </div>
                            </div>
                        </div>

                        <div class="stat-badge border-purple-500 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-md p-6 text-center">
                            <p class="text-gray-600 text-xs uppercase font-semibold mb-4">Rata-rata Nilai</p>
                            <div class="score-circle">
                                <svg width="140" height="140" class="w-full h-full">
                                    <circle cx="70" cy="70" r="65" fill="none" stroke="rgba(168, 85, 247, 0.2)" stroke-width="6"/>
                                    <circle cx="70" cy="70" r="65" fill="none" stroke="#a855f7" stroke-width="6" 
                                            stroke-dasharray="<?php echo (408.41 * ($evaluasi['rata_rata'] / 100)); ?>" 
                                            stroke-dashoffset="0" stroke-linecap="round"/>
                                </svg>
                                <div class="score-value">
                                    <span class="text-3xl font-bold text-purple-600"><?= number_format($evaluasi['rata_rata'], 1) ?></span>
                                    <span class="text-xs text-gray-600">dari 100</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 md:p-8 mb-8 border-t-4 border-blue-600">
                        <h2 class="text-lg font-bold text-gray-900 mb-6">Perbandingan Nilai</h2>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-gray-700">Kehadiran</span>
                                    <span class="text-sm font-bold text-blue-600"><?= $evaluasi['nilai_kehadiran'] ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-blue-600 h-3 rounded-full" style="width: <?= $evaluasi['nilai_kehadiran'] ?>%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-gray-700">Kinerja</span>
                                    <span class="text-sm font-bold text-green-600"><?= $evaluasi['nilai_kinerja'] ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-green-600 h-3 rounded-full" style="width: <?= $evaluasi['nilai_kinerja'] ?>%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-gray-700">Sikap</span>
                                    <span class="text-sm font-bold text-yellow-600"><?= $evaluasi['nilai_sikap'] ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-yellow-600 h-3 rounded-full" style="width: <?= $evaluasi['nilai_sikap'] ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($evaluasi['komentar']): ?>
                    <div class="bg-blue-50 rounded-lg shadow-md p-6 md:p-8 mb-8 border-l-4 border-blue-600">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-comment-dots text-blue-600"></i>
                            Komentar dari Mentor
                        </h2>
                        <div class="bg-white rounded-lg p-4 border border-blue-200">
                            <p class="text-gray-800 leading-relaxed"><?= nl2br(htmlspecialchars($evaluasi['komentar'])) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="bg-white rounded-lg shadow-md p-6 md:p-8 border-t-4 border-gray-600">
                        <h2 class="text-lg font-bold text-gray-900 mb-6">Interpretasi Nilai</h2>
                        <div class="interpretation-grid">
                            <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                                <p class="text-sm font-semibold text-gray-700">80 - 100</p>
                                <p class="text-lg font-bold text-green-600 mt-1">Sangat Baik</p>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                                <p class="text-sm font-semibold text-gray-700">70 - 79</p>
                                <p class="text-lg font-bold text-blue-600 mt-1">Baik</p>
                            </div>
                            <div class="bg-yellow-50 rounded-lg p-4 border-l-4 border-yellow-500">
                                <p class="text-sm font-semibold text-gray-700">60 - 69</p>
                                <p class="text-lg font-bold text-yellow-600 mt-1">Cukup</p>
                            </div>
                            <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-500">
                                <p class="text-sm font-semibold text-gray-700">Dibawah 60</p>
                                <p class="text-lg font-bold text-red-600 mt-1">Kurang</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>