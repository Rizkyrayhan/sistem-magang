<?php
if (!isAdmin()) redirect('login');

$total = countPendaftar($conn);
$menunggu = countPendaftar($conn, 'menunggu');
$diterima = countPendaftar($conn, 'diterima');
$ditolak = countPendaftar($conn, 'ditolak');
$evaluasi_selesai = $conn->query("SELECT COUNT(*) as total FROM evaluasi WHERE status = 'selesai'")->fetch_assoc()['total'];

$recent = $conn->query("SELECT p.*, u.nama FROM pendaftar p JOIN users u ON p.user_id = u.id ORDER BY p.tanggal_daftar DESC LIMIT 5");

$current = 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LEMIGAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
                        <!-- Hamburger for Mobile -->
                        <button id="sidebarToggle" class="md:hidden p-2 hover:bg-gray-100 rounded-lg transition text-gray-700">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                        
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Dashboard Utama</h1>
                            <p class="text-xs md:text-sm text-gray-600 hidden md:block">Kelola pendaftaran dan evaluasi magang</p>
                        </div>
                    </div>

                    <div class="hidden md:flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm text-gray-700 font-medium">Selamat datang kembali!</p>
                            <p class="text-xs text-gray-500">Terakhir login: Hari ini, <?php echo date('H:i'); ?></p>
                        </div>
                        <button class="p-2 hover:bg-gray-100 rounded-lg transition relative">
                            <i class="fas fa-bell text-xl text-gray-700"></i>
                            <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-4 md:p-8">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
                        <!-- Total Pendaftar -->
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-4 md:p-6 rounded-xl shadow-sm hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-blue-100 text-xs md:text-sm font-medium">Total Pendaftar</p>
                                    <p class="text-3xl md:text-4xl font-bold mt-2"><?php echo $total; ?></p>
                                    <p class="text-xs text-blue-200 mt-2">↑ +12% dari bulan lalu</p>
                                </div>
                                <div class="text-2xl md:text-4xl opacity-40">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Menunggu Persetujuan -->
                        <div class="bg-gradient-to-br from-orange-400 to-orange-500 text-white p-4 md:p-6 rounded-xl shadow-sm hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-orange-100 text-xs md:text-sm font-medium">Menunggu Persetujuan</p>
                                    <p class="text-3xl md:text-4xl font-bold mt-2"><?php echo $menunggu; ?></p>
                                    <p class="text-xs text-orange-200 mt-2">▲ Perlu review</p>
                                </div>
                                <div class="text-2xl md:text-4xl opacity-40">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Magang Aktif -->
                        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-4 md:p-6 rounded-xl shadow-sm hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-green-100 text-xs md:text-sm font-medium">Magang Aktif</p>
                                    <p class="text-3xl md:text-4xl font-bold mt-2"><?php echo $diterima; ?></p>
                                    <p class="text-xs text-green-200 mt-2">● Sedang berjalan</p>
                                </div>
                                <div class="text-2xl md:text-4xl opacity-40">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Selesai Evaluasi -->
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-4 md:p-6 rounded-xl shadow-sm hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-purple-100 text-xs md:text-sm font-medium">Selesai Evaluasi</p>
                                    <p class="text-3xl md:text-4xl font-bold mt-2"><?php echo $evaluasi_selesai; ?></p>
                                    <p class="text-xs text-purple-200 mt-2">✓ Sudah dinilai</p>
                                </div>
                                <div class="text-2xl md:text-4xl opacity-40">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-sm p-6 md:p-8 mb-8 border border-gray-200">
                        <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-4">Aksi Cepat</h2>
                        <p class="text-sm text-gray-600 mb-6">Tindakan yang sering dilakukan</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                            <a href="<?php echo SITE_URL; ?>admin/data-pendaftar" class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-6 md:p-8 text-center hover:border-blue-400 hover:bg-blue-50 transition group">
                                <div class="w-12 h-12 md:w-16 md:h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition">
                                    <i class="fas fa-user-plus text-xl md:text-2xl text-blue-600"></i>
                                </div>
                                <h3 class="font-bold text-gray-900 text-sm md:text-base">Review Pendaftaran</h3>
                                <p class="text-xs md:text-sm text-gray-600 mt-2">Setujui atau tolak pendaftar</p>
                            </a>

                            <a href="<?php echo SITE_URL; ?>admin/evaluasi" class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-6 md:p-8 text-center hover:border-green-400 hover:bg-green-50 transition group">
                                <div class="w-12 h-12 md:w-16 md:h-16 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition">
                                    <i class="fas fa-edit text-xl md:text-2xl text-green-600"></i>
                                </div>
                                <h3 class="font-bold text-gray-900 text-sm md:text-base">Input Evaluasi</h3>
                                <p class="text-xs md:text-sm text-gray-600 mt-2">Beri nilai hasil magang</p>
                            </a>

                            <button onclick="alert('Fitur export Excel segera hadir!')" class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-6 md:p-8 text-center hover:border-purple-400 hover:bg-purple-50 transition group cursor-pointer">
                                <div class="w-12 h-12 md:w-16 md:h-16 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-200 transition">
                                    <i class="fas fa-file-excel text-xl md:text-2xl text-purple-600"></i>
                                </div>
                                <h3 class="font-bold text-gray-900 text-sm md:text-base">Unduh Laporan</h3>
                                <p class="text-xs md:text-sm text-gray-600 mt-2">Export data ke Excel</p>
                            </button>
                        </div>
                    </div>

                    <!-- Recent Registrations -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-6 md:p-8 border-b border-gray-200">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                                <div>
                                    <h2 class="text-lg md:text-xl font-bold text-gray-900">Pendaftaran Terbaru</h2>
                                    <p class="text-sm text-gray-600 mt-1">Mahasiswa yang baru mendaftar magang</p>
                                </div>
                                <a href="<?php echo SITE_URL; ?>admin/data-pendaftar" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lihat Semua →</a>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-200">
                                        <th class="text-left py-3 px-4 md:px-6 font-semibold text-gray-700 text-xs uppercase">MAHASISWA</th>
                                        <th class="text-left py-3 px-4 md:px-6 font-semibold text-gray-700 text-xs uppercase hidden md:table-cell">JURUSAN</th>
                                        <th class="text-left py-3 px-4 md:px-6 font-semibold text-gray-700 text-xs uppercase hidden lg:table-cell">TEMPAT MAGANG</th>
                                        <th class="text-left py-3 px-4 md:px-6 font-semibold text-gray-700 text-xs uppercase">STATUS</th>
                                        <th class="text-center py-3 px-4 md:px-6 font-semibold text-gray-700 text-xs uppercase">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php while($r = $recent->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-4 px-4 md:px-6">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                    <?php echo strtoupper(substr($r['nama'], 0, 1)); ?>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-semibold text-gray-900 text-sm truncate"><?php echo htmlspecialchars($r['nama']); ?></p>
                                                    <p class="text-xs text-gray-500 truncate"><?php echo $r['nim'] ?: 'NIM belum diisi'; ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 md:px-6 text-gray-700 hidden md:table-cell text-xs md:text-sm"><?php echo htmlspecialchars($r['jurusan'] ?: '-'); ?></td>
                                        <td class="py-4 px-4 md:px-6 text-gray-700 hidden lg:table-cell text-xs md:text-sm"><?php echo htmlspecialchars($r['universitas'] ?: '-'); ?></td>
                                        <td class="py-4 px-4 md:px-6">
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold <?php 
                                                echo $r['status'] == 'diterima' ? 'bg-green-100 text-green-800' : 
                                                    ($r['status'] == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800');
                                            ?>">
                                                <?php echo ucfirst($r['status']); ?>
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 md:px-6 text-center space-x-2">
                                            <a href="<?php echo SITE_URL; ?>admin/detail-pendaftar?id=<?php echo $r['id']; ?>" class="text-blue-600 hover:text-blue-900 font-medium text-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="text-green-600 hover:text-green-900 text-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900 text-sm">
                                                <i class="fas fa-times"></i>
                                            </button>
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
    </div>

    <script>
        // Script untuk toggle sidebar sudah di sidebar.php
        // Ini hanya untuk memastikan button memiliki id yang benar
        document.addEventListener('DOMContentLoaded', function() {
            const topBarToggle = document.querySelector('.md\\:hidden[id="sidebarToggle"]');
            if (topBarToggle) {
                console.log('Top bar toggle button found');
            }
        });
    </script>
</body>
</html>