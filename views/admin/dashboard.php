<?php
if (!isAdmin()) redirect('login');

$total = countPendaftar($conn);
$menunggu = countPendaftar($conn, 'menunggu');
$diterima = countPendaftar($conn, 'diterima');
$ditolak = countPendaftar($conn, 'ditolak');
$evaluasi_selesai = $conn->query("SELECT COUNT(*) as total FROM evaluasi WHERE status = 'selesai'")->fetch_assoc()['total'];

$recent = $conn->query("SELECT p.*, u.nama FROM pendaftar p JOIN users u ON p.user_id = u.id ORDER BY p.tanggal_daftar DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LEMIGAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include 'partials/sidebar.php'; ?>
        <div class="flex-1 overflow-y-auto p-8">

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <div class="p-8">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Dashboard Utama</h1>
                        <p class="text-gray-600">Kelola pendaftaran dan evaluasi magang</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Selamat datang kembali!</p>
                        <p class="text-xs text-gray-500">Terakhir login: Hari ini, <?php echo date('H:i'); ?></p>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-blue-600 text-white p-6 rounded-xl shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100">Total Pendaftar</p>
                                <p class="text-4xl font-bold mt-2"><?php echo $total; ?></p>
                                <p class="text-sm text-blue-100 mt-2">↑ +12% dari bulan lalu</p>
                            </div>
                            <i class="fas fa-users text-4xl opacity-50"></i>
                        </div>
                    </div>
                    <div class="bg-orange-500 text-white p-6 rounded-xl shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100">Menunggu Persetujuan</p>
                                <p class="text-4xl font-bold mt-2"><?php echo $menunggu; ?></p>
                                <p class="text-sm text-orange-100 mt-2">△ Perlu review</p>
                            </div>
                            <i class="fas fa-clock text-4xl opacity-50"></i>
                        </div>
                    </div>
                    <div class="bg-green-500 text-white p-6 rounded-xl shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100">Magang Aktif</p>
                                <p class="text-4xl font-bold mt-2"><?php echo $diterima; ?></p>
                                <p class="text-sm text-green-100 mt-2">● Sedang berjalan</p>
                            </div>
                            <i class="fas fa-check-circle text-4xl opacity-50"></i>
                        </div>
                    </div>
                    <div class="bg-purple-600 text-white p-6 rounded-xl shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100">Selesai Evaluasi</p>
                                <p class="text-4xl font-bold mt-2"><?php echo $evaluasi_selesai; ?></p>
                                <p class="text-sm text-purple-100 mt-2">✓ Sudah dinilai</p>
                            </div>
                            <i class="fas fa-star text-4xl opacity-50"></i>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Aksi Cepat</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <a href="<?php echo SITE_URL; ?>admin/data-pendaftar" class="bg-blue-50 border-2 border-dashed border-blue-300 rounded-xl p-8 text-center hover:bg-blue-100 transition">
                            <i class="fas fa-user-plus text-4xl text-blue-600 mb-4"></i>
                            <h3 class="font-bold text-blue-800">Review Pendaftaran</h3>
                            <p class="text-sm text-gray-600 mt-2">Setujui atau tolak pendaftar</p>
                        </a>
                        <a href="<?php echo SITE_URL; ?>admin/evaluasi" class="bg-green-50 border-2 border-dashed border-green-300 rounded-xl p-8 text-center hover:bg-green-100 transition">
                            <i class="fas fa-edit text-4xl text-green-600 mb-4"></i>
                            <h3 class="font-bold text-green-800">Input Evaluasi</h3>
                            <p class="text-sm text-gray-600 mt-2">Beri nilai hasil magang</p>
                        </a>
                        <button onclick="alert('Fitur export Excel segera hadir!')" class="bg-purple-50 border-2 border-dashed border-purple-300 rounded-xl p-8 text-center hover:bg-purple-100 transition cursor-pointer">
                            <i class="fas fa-file-excel text-4xl text-purple-600 mb-4"></i>
                            <h3 class="font-bold text-purple-800">Unduh Laporan</h3>
                            <p class="text-sm text-gray-600 mt-2">Export data ke Excel</p>
                        </button>
                    </div>
                </div>

                <!-- Recent Registrations -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Pendaftaran Terbaru</h2>
                            <p class="text-gray-600">Mahasiswa yang baru mendaftar magang</p>
                        </div>
                        <a href="<?php echo SITE_URL; ?>admin/data-pendaftar" class="text-blue-600 hover:text-blue-800 font-medium">Lihat Semua →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Mahasiswa</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Jurusan</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Tempat Magang</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($r = $recent->fetch_assoc()): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                                <?php echo strtoupper(substr($r['nama'], 0, 1)); ?>
                                            </div>
                                            <div>
                                                <p class="font-medium"><?php echo $r['nama']; ?></p>
                                                <p class="text-xs text-gray-500"><?php echo $r['nim'] ?: 'NIM belum diisi'; ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-sm"><?php echo $r['jurusan'] ?: '-'; ?></td>
                                    <td class="py-4 px-4 text-sm"><?php echo $r['universitas'] ?: '-'; ?></td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium <?php 
                                            echo $r['status'] == 'diterima' ? 'bg-green-100 text-green-800' : 
                                                ($r['status'] == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800');
                                        ?>">
                                            <?php echo ucfirst($r['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>