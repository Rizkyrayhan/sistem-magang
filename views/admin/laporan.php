<?php
// session_start();
// require_once '../../config.php';
// require_once '../../src/helpers/helper.php';

if (!isAdmin()) redirect('login');

// Get statistics
$total_pendaftar = countPendaftar($conn);
$menunggu = countPendaftar($conn, 'menunggu');
$diterima = countPendaftar($conn, 'diterima');
$ditolak = countPendaftar($conn, 'ditolak');
$proses = countPendaftar($conn, 'proses');

// Get all pendaftar dengan evaluasi
$sql = "SELECT p.*, u.nama, u.email, e.rata_rata, e.status as eval_status 
        FROM pendaftar p 
        JOIN users u ON p.user_id = u.id 
        LEFT JOIN evaluasi e ON p.id = e.pendaftar_id 
        ORDER BY p.tanggal_daftar DESC";

$result = $conn->query($sql);
$all_data = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan & Analisis - LEMIGAS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg min-h-screen">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 4h16v2H4V4zm0 7h16v2H4v-2zm0 7h16v2H4v-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-gray-800">LEMIGAS</h1>
                        <p class="text-xs text-gray-500">Admin Dashboard</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-2">
                <a href="<?php echo SITE_URL; ?>admin/dashboard" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo SITE_URL; ?>admin/data-pendaftar" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Data Pendaftar</span>
                </a>
                <a href="<?php echo SITE_URL; ?>admin/evaluasi" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/></svg>
                    <span>Evaluasi</span>
                </a>
                <a href="<?php echo SITE_URL; ?>admin/laporan" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/></svg>
                    <span>Laporan</span>
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
            <div class="bg-white shadow-sm border-b border-gray-200 p-6">
                <h2 class="text-2xl font-bold text-gray-800">Laporan & Analisis</h2>
                <p class="text-gray-600 text-sm">Visualisasi data dan ekspor laporan</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-600 text-sm">Total Mahasiswa</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2"><?php echo $total_pendaftar; ?></p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-600 text-sm">Menunggu Review</p>
                                <p class="text-3xl font-bold text-yellow-600 mt-2"><?php echo $menunggu; ?></p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-600 text-sm">Diterima</p>
                                <p class="text-3xl font-bold text-green-600 mt-2"><?php echo $diterima; ?></p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-600 text-sm">Sedang Magang</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2"><?php echo $proses; ?></p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v6h16V5a2 2 0 00-2-2H5z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-600 text-sm">Ditolak</p>
                                <p class="text-3xl font-bold text-red-600 mt-2"><?php echo $ditolak; ?></p>
                            </div>
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export Section -->
                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Ekspor Data</h3>
                            <p class="text-gray-600 text-sm">Download laporan dalam format Excel</p>
                        </div>
                        <button onclick="exportToExcel()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition">
                            📥 Export ke Excel
                        </button>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800">Rekap Data Lengkap</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="px-6 py-3 text-left text-gray-700 font-medium">#</th>
                                    <th class="px-6 py-3 text-left text-gray-700 font-medium">Nama</th>
                                    <th class="px-6 py-3 text-left text-gray-700 font-medium">NIM</th>
                                    <th class="px-6 py-3 text-left text-gray-700 font-medium">Universitas</th>
                                    <th class="px-6 py-3 text-left text-gray-700 font-medium">Jurusan</th>
                                    <th class="px-6 py-3 text-left text-gray-700 font-medium">Status Pendaftaran</th>
                                    <th class="px-6 py-3 text-left text-gray-700 font-medium">Nilai Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($all_data as $item): ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-800"><?php echo $no++; ?></td>
                                    <td class="px-6 py-4 text-gray-800"><?php echo $item['nama']; ?></td>
                                    <td class="px-6 py-4 text-gray-800"><?php echo $item['nim'] ?: '-'; ?></td>
                                    <td class="px-6 py-4 text-gray-800"><?php echo $item['universitas'] ?: '-'; ?></td>
                                    <td class="px-6 py-4 text-gray-800"><?php echo $item['jurusan'] ?: '-'; ?></td>
                                    <td class="px-6 py-4"><?php echo getBadgeStatus($item['status']); ?></td>
                                    <td class="px-6 py-4 text-gray-800">
                                        <?php echo $item['rata_rata'] ? number_format($item['rata_rata'], 2) : '-'; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function exportToExcel() {
            let csv = 'No,Nama,NIM,Universitas,Jurusan,Status Pendaftaran,Nilai Rata-rata\n';
            
            <?php $no = 1; foreach ($all_data as $item): ?>
                csv += '<?php echo $no++ . "," . $item['nama'] . "," . ($item['nim'] ?: '-') . "," . ($item['universitas'] ?: '-') . "," . ($item['jurusan'] ?: '-') . "," . $item['status'] . "," . ($item['rata_rata'] ?: '-'); ?>\n';
            <?php endforeach; ?>
            
            let link = document.createElement('a');
            link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
            link.download = 'laporan-magang-' + new Date().getTime() + '.csv';
            link.click();
        }
    </script>
</body>
</html>