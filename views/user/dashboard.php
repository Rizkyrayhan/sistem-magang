<?php
// session_start();
// require_once '../../config.php';
// require_once '../../src/helpers/helper.php';

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
    <title>Dashboard Pendaftar - LEMIGAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg min-h-screen">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold">
                        <?php echo strtoupper(substr($user['nama'], 0, 1)); ?>
                    </div>
                    <div>
                        <h1 class="font-bold text-gray-800 text-sm"><?php echo $user['nama']; ?></h1>
                        <p class="text-xs text-gray-500">Peserta Magang</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-2">
                <a href="<?php echo SITE_URL; ?>user/dashboard" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo SITE_URL; ?>user/status-pendaftaran" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/></svg>
                    <span>Status Pendaftaran</span>
                </a>
                <a href="<?php echo SITE_URL; ?>user/hasil-evaluasi" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v6h16V5a2 2 0 00-2-2H5z"/></svg>
                    <span>Hasil Evaluasi</span>
                </a>
                <hr class="my-4">
                <a href="<?php echo SITE_URL; ?>logout" class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1z"/></svg>
                    <span>Logout</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-8">
                <div class="max-w-4xl">
                    <h2 class="text-3xl font-bold mb-2">Selamat Datang, <?php echo $user['nama']; ?>!</h2>
                    <p class="text-blue-100">Kelola pendaftaran dan evaluasi magang Anda di sini</p>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Status Pendaftaran -->
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-600 text-sm">Status Pendaftaran</p>
                                <p class="text-2xl font-bold text-gray-800 mt-2">
                                    <?php echo ucfirst(str_replace(['menunggu', 'diterima', 'ditolak', 'proses'], 
                                                                  ['Menunggu', 'Diterima', 'Ditolak', 'Proses'], 
                                                                  $pendaftar['status'])); ?>
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Daftar -->
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-600 text-sm">Tanggal Pendaftaran</p>
                                <p class="text-lg font-bold text-gray-800 mt-2"><?php echo formatTanggal($pendaftar['tanggal_daftar']); ?></p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M6 2a1 1 0 000 2h8a1 1 0 100-2H6z"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Status Evaluasi -->
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-600 text-sm">Status Evaluasi</p>
                                <p class="text-lg font-bold text-gray-800 mt-2">
                                    <?php echo $evaluasi ? ($evaluasi['status'] === 'selesai' ? 'Selesai' : 'Belum') : 'Belum'; ?>
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v6h16V5a2 2 0 00-2-2H5z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Pendaftar -->
                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Data Pendaftaran</h3>
                        <a href="<?php echo SITE_URL; ?>user/status-pendaftaran" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit →</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Nama Lengkap</p>
                            <p class="text-gray-800 font-medium mt-1"><?php echo $user['nama']; ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Email</p>
                            <p class="text-gray-800 font-medium mt-1"><?php echo $user['email']; ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">NIM</p>
                            <p class="text-gray-800 font-medium mt-1"><?php echo $pendaftar['nim'] ?: '-'; ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Jurusan</p>
                            <p class="text-gray-800 font-medium mt-1"><?php echo $pendaftar['jurusan'] ?: '-'; ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Universitas</p>
                            <p class="text-gray-800 font-medium mt-1"><?php echo $pendaftar['universitas'] ?: '-'; ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Bidang Minat</p>
                            <p class="text-gray-800 font-medium mt-1"><?php echo $pendaftar['bidang_minat'] ?: '-'; ?></p>
                        </div>
                    </div>
                </div>

                <!-- Evaluasi Summary -->
                <?php if ($evaluasi && $evaluasi['status'] === 'selesai'): ?>
                <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg shadow p-6 border-l-4 border-purple-500">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Evaluasi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white rounded-lg p-4">
                            <p class="text-gray-600 text-sm">Nilai Kehadiran</p>
                            <p class="text-2xl font-bold text-blue-600 mt-2"><?php echo $evaluasi['nilai_kehadiran']; ?></p>
                        </div>
                        <div class="bg-white rounded-lg p-4">
                            <p class="text-gray-600 text-sm">Nilai Kinerja</p>
                            <p class="text-2xl font-bold text-green-600 mt-2"><?php echo $evaluasi['nilai_kinerja']; ?></p>
                        </div>
                        <div class="bg-white rounded-lg p-4">
                            <p class="text-gray-600 text-sm">Nilai Sikap</p>
                            <p class="text-2xl font-bold text-yellow-600 mt-2"><?php echo $evaluasi['nilai_sikap']; ?></p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border-2 border-purple-500">
                            <p class="text-gray-600 text-sm">Rata-rata</p>
                            <p class="text-2xl font-bold text-purple-600 mt-2"><?php echo number_format($evaluasi['rata_rata'], 2); ?></p>
                        </div>
                    </div>
                    <?php if ($evaluasi['komentar']): ?>
                    <div class="mt-4 bg-white rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">Komentar dari Mentor</p>
                        <p class="text-gray-800 mt-2"><?php echo $evaluasi['komentar']; ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>