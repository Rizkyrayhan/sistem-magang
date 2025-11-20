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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="flex">
        <!-- Sidebar -->
        <?php $current = 'dashboard'; ?>
        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content flex-1 overflow-y-auto bg-gray-50 min-h-screen">
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
                                <div class="text-blue-600 text-3xl">
                                <i class="fas fa-user-check"></i>
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
                            <div class="text-green-600 text-4xl">
                                <i class="fas fa-calendar-check"></i>
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
                                <div class="text-purple-600 text-4xl">
                                    <i class="fas fa-clipboard-list"></i>
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