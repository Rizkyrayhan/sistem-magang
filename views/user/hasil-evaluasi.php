<?php
if (!isLoggedIn() || !isPendaftar()) {
    redirect('login');
}

$user = getCurrentUser();
$pendaftar = getPendaftar($conn, $user['id']);
$evaluasi = $pendaftar ? getEvaluasi($conn, $pendaftar['id']) : null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Evaluasi - LEMIGAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="flex">
        <!-- Sidebar -->
        <?php $current = 'evaluasi'; ?>
        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content flex-1 overflow-y-auto bg-gray-50 min-h-screen">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-8">
                <div class="max-w-4xl">
                    <h2 class="text-3xl font-bold mb-2">Hasil Evaluasi</h2>
                    <p class="text-blue-100">Lihat hasil evaluasi magang Anda</p>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <?php if (!$evaluasi || $evaluasi['status'] !== 'selesai'): ?>
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            </svg>
                        </div>
                        <p class="text-gray-600 text-lg">Evaluasi Anda belum tersedia</p>
                        <p class="text-gray-500 text-sm mt-2">Evaluasi akan ditampilkan setelah mentor selesai memberikan penilaian</p>
                    </div>
                <?php else: ?>
                    <!-- Hasil Evaluasi -->
                    <div class="max-w-4xl">
                        <!-- Kartu Info -->
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-8 text-white mb-8">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-purple-100 text-sm">Peserta Magang</p>
                                    <p class="text-2xl font-bold"><?php echo $user['nama']; ?></p>
                                    <p class="text-purple-100 text-sm mt-2">NIM: <?php echo $pendaftar['nim'] ?: '-'; ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-purple-100 text-sm">Tanggal Evaluasi</p>
                                    <p class="text-lg font-bold"><?php echo formatTanggal($evaluasi['tanggal_evaluasi']); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Nilai Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                            <!-- Kehadiran -->
                            <div class="bg-white rounded-lg shadow p-6">
                                <div class="text-center">
                                    <p class="text-gray-600 text-sm font-medium mb-3">Nilai Kehadiran</p>
                                    <div class="relative w-24 h-24 mx-auto mb-3">
                                        <svg class="transform -rotate-90 w-24 h-24" style="width: 100px; height: 100px;">
                                            <circle cx="50" cy="50" r="45" fill="none" stroke="#e5e7eb" stroke-width="8"/>
                                            <circle cx="50" cy="50" r="45" fill="none" stroke="#3b82f6" stroke-width="8" 
                                                    stroke-dasharray="<?php echo (282.6 * $evaluasi['nilai_kehadiran'] / 100); ?>" 
                                                    stroke-dashoffset="0"/>
                                        </svg>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="text-2xl font-bold text-blue-600"><?php echo $evaluasi['nilai_kehadiran']; ?></span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500">dari 100</p>
                                </div>
                            </div>

                            <!-- Kinerja -->
                            <div class="bg-white rounded-lg shadow p-6">
                                <div class="text-center">
                                    <p class="text-gray-600 text-sm font-medium mb-3">Nilai Kinerja</p>
                                    <div class="relative w-24 h-24 mx-auto mb-3">
                                        <svg class="transform -rotate-90 w-24 h-24" style="width: 100px; height: 100px;">
                                            <circle cx="50" cy="50" r="45" fill="none" stroke="#e5e7eb" stroke-width="8"/>
                                            <circle cx="50" cy="50" r="45" fill="none" stroke="#10b981" stroke-width="8" 
                                                    stroke-dasharray="<?php echo (282.6 * $evaluasi['nilai_kinerja'] / 100); ?>" 
                                                    stroke-dashoffset="0"/>
                                        </svg>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="text-2xl font-bold text-green-600"><?php echo $evaluasi['nilai_kinerja']; ?></span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500">dari 100</p>
                                </div>
                            </div>

                            <!-- Sikap -->
                            <div class="bg-white rounded-lg shadow p-6">
                                <div class="text-center">
                                    <p class="text-gray-600 text-sm font-medium mb-3">Nilai Sikap</p>
                                    <div class="relative w-24 h-24 mx-auto mb-3">
                                        <svg class="transform -rotate-90 w-24 h-24" style="width: 100px; height: 100px;">
                                            <circle cx="50" cy="50" r="45" fill="none" stroke="#e5e7eb" stroke-width="8"/>
                                            <circle cx="50" cy="50" r="45" fill="none" stroke="#f59e0b" stroke-width="8" 
                                                    stroke-dasharray="<?php echo (282.6 * $evaluasi['nilai_sikap'] / 100); ?>" 
                                                    stroke-dashoffset="0"/>
                                        </svg>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="text-2xl font-bold text-yellow-600"><?php echo $evaluasi['nilai_sikap']; ?></span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500">dari 100</p>
                                </div>
                            </div>

                            <!-- Rata-rata -->
                            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow p-6 text-white">
                                <div class="text-center">
                                    <p class="text-purple-100 text-sm font-medium mb-3">Rata-rata Nilai</p>
                                    <div class="relative w-24 h-24 mx-auto mb-3">
                                        <svg class="transform -rotate-90 w-24 h-24" style="width: 100px; height: 100px;">
                                            <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="8"/>
                                            <circle cx="50" cy="50" r="45" fill="none" stroke="white" stroke-width="8" 
                                                    stroke-dasharray="<?php echo (282.6 * ($evaluasi['rata_rata'] / 100)); ?>" 
                                                    stroke-dashoffset="0"/>
                                        </svg>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="text-2xl font-bold"><?php echo number_format($evaluasi['rata_rata'], 1); ?></span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-purple-100">dari 100</p>
                                </div>
                            </div>
                        </div>

                        <!-- Komentar Mentor -->
                        <?php if ($evaluasi['komentar']): ?>
                        <div class="bg-white rounded-lg shadow p-8 mb-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Komentar dari Mentor</h3>
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded">
                                <p class="text-gray-800"><?php echo nl2br(htmlspecialchars($evaluasi['komentar'])); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Interpretasi Nilai -->
                        <div class="bg-white rounded-lg shadow p-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Interpretasi Nilai</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">80-100</span>
                                    <span class="text-green-600 font-semibold">Sangat Baik</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">70-79</span>
                                    <span class="text-blue-600 font-semibold">Baik</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">60-69</span>
                                    <span class="text-yellow-600 font-semibold">Cukup</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">Dibawah 60</span>
                                    <span class="text-red-600 font-semibold">Kurang</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>