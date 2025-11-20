<?php
require_once __DIR__ . '/../../src/helpers/helper.php';
if (!isAdmin()) redirect('login');

// Statistik umum
$total = $conn->query("SELECT COUNT(*) FROM pendaftar")->fetch_row()[0];
$diterima = $conn->query("SELECT COUNT(*) FROM pendaftar WHERE status = 'diterima'")->fetch_row()[0];
$ditolak = $conn->query("SELECT COUNT(*) FROM pendaftar WHERE status = 'ditolak'")->fetch_row()[0];
$menunggu = $total - $diterima - $ditolak;

// Rata-rata nilai evaluasi (DINAMIS DARI DATABASE)
$avg = $conn->query("SELECT 
    COALESCE(AVG(nilai_kehadiran), 0) AS kehadiran,
    COALESCE(AVG(nilai_kinerja), 0) AS kinerja,
    COALESCE(AVG(nilai_sikap), 0) AS sikap,
    COALESCE(AVG(rata_rata), 0) AS akhir
    FROM evaluasi")->fetch_assoc();

$kehadiran = round($avg['kehadiran'], 1);
$kinerja   = round($avg['kinerja'], 1);
$sikap     = round($avg['sikap'], 1);
$akhir     = round($avg['akhir'], 1);

$current = 'laporan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan & Analisis - LEMIGAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Laporan & Analisis</h1>
                    <p class="text-gray-600">Visualisasi data pendaftaran dan evaluasi magang</p>
                </div>
                <a href="<?= SITE_URL ?>admin/export-excel" class="bg-green-600 hover:bg-green-700 text-white font-bold px-8 py-4 rounded-xl shadow-lg flex items-center gap-3 transition transform hover:scale-105">
                    <i class="fas fa-file-excel text-2xl"></i> Export ke Excel
                </a>
            </div>

            <!-- Statistik Kartu -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-8 rounded-2xl shadow-xl">
                    <p class="text-blue-100 text-lg">Total Pendaftar</p>
                    <p class="text-5xl font-bold mt-2"><?= $total ?></p>
                </div>
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-8 rounded-2xl shadow-xl">
                    <p class="text-green-100 text-lg">Diterima</p>
                    <p class="text-5xl font-bold mt-2"><?= $diterima ?></p>
                </div>
                <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-8 rounded-2xl shadow-xl">
                    <p class="text-red-100 text-lg">Ditolak</p>
                    <p class="text-5xl font-bold mt-2"><?= $ditolak ?></p>
                </div>
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-8 rounded-2xl shadow-xl">
                    <p class="text-yellow-100 text-lg">Menunggu</p>
                    <p class="text-5xl font-bold mt-2"><?= $menunggu ?></p>
                </div>
            </div>

            <!-- Chart -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-xl">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Rata-rata Nilai Evaluasi</h2>
                    <canvas id="chartNilai" height="300"></canvas>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-xl">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Distribusi Status Pendaftaran</h2>
                    <canvas id="chartStatus" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script>
    // Chart Rata-rata Nilai
    new Chart(document.getElementById('chartNilai'), {
        type: 'bar',
        data: {
            labels: ['Kehadiran', 'Kinerja', 'Sikap', 'Nilai Akhir'],
            datasets: [{
                label: 'Rata-rata Nilai',
                data: [<?= $kehadiran ?>, <?= $kinerja ?>, <?= $sikap ?>, <?= $akhir ?>],
                backgroundColor: ['#3B82F6', '#10B981', '#8B5CF6', '#F59E0B'],
                borderRadius: 8,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, max: 100, ticks: { stepSize: 10 } } }
        }
    });

    // Chart Distribusi Status
    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: ['Diterima', 'Ditolak', 'Menunggu'],
            datasets: [{
                data: [<?= $diterima ?>, <?= $ditolak ?>, <?= $menunggu ?>],
                backgroundColor: ['#10B981', '#EF4444', '#F59E0B'],
                borderWidth: 0,
                cutout: '70%'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
    </script>
</body>
</html>