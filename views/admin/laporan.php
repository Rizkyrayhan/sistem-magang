<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/helpers/helper.php';

if (!isAdmin()) redirect('login');

// Statistik umum
$total = $conn->query("SELECT COUNT(*) FROM pendaftar")->fetch_row()[0];
$diterima = $conn->query("SELECT COUNT(*) FROM pendaftar WHERE status = 'diterima'")->fetch_row()[0];
$ditolak = $conn->query("SELECT COUNT(*) FROM pendaftar WHERE status = 'ditolak'")->fetch_row()[0];
$menunggu = $total - $diterima - $ditolak;

// Rata-rata nilai evaluasi
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
    <style>
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }
        }

        @keyframes chartGlow {
            0% {
                filter: drop-shadow(0 0 5px rgba(59, 130, 246, 0));
            }
            50% {
                filter: drop-shadow(0 0 15px rgba(59, 130, 246, 0.5));
            }
            100% {
                filter: drop-shadow(0 0 5px rgba(59, 130, 246, 0));
            }
        }

        .animate-slide-up {
            animation: slideInUp 0.6s ease-out forwards;
        }

        .animate-slide-left {
            animation: slideInLeft 0.6s ease-out forwards;
        }

        .stat-card {
            animation: slideInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        .chart-container {
            animation: slideInLeft 0.6s ease-out forwards;
            opacity: 0;
        }

        .chart-container:nth-child(1) { animation-delay: 0.5s; }
        .chart-container:nth-child(2) { animation-delay: 0.6s; }

        .chart-wrapper {
            animation: scaleIn 0.8s ease-out 0.5s forwards;
            opacity: 0;
        }

        .chart-wrapper:nth-child(1) {
            animation-delay: 0.7s;
        }

        .chart-wrapper:nth-child(2) {
            animation-delay: 0.8s;
        }

        canvas {
            animation: chartGlow 2s ease-in-out 1s infinite;
        }

        .summary-container {
            animation: slideInUp 0.6s ease-out forwards;
            opacity: 0;
            animation-delay: 0.7s;
        }

        .summary-card {
            animation: slideInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .summary-card:nth-child(1) { animation-delay: 0.8s; }
        .summary-card:nth-child(2) { animation-delay: 0.9s; }
        .summary-card:nth-child(3) { animation-delay: 1s; }
        .summary-card:nth-child(4) { animation-delay: 1.1s; }

        .chart-title {
            animation: slideInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .chart-container:nth-child(1) .chart-title {
            animation-delay: 0.55s;
        }

        .chart-container:nth-child(2) .chart-title {
            animation-delay: 0.65s;
        }
    </style>
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
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Laporan & Analisis</h1>
                            <p class="text-xs md:text-sm text-gray-600 hidden md:block">Visualisasi data pendaftaran dan evaluasi magang</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-4 md:p-8">
                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-8">
                        <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 text-white p-4 md:p-6 rounded-lg shadow-md hover:shadow-lg transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-blue-100 text-xs md:text-sm font-medium">Total Mahasiswa</p>
                                    <p class="text-2xl md:text-4xl font-bold mt-2 md:mt-3 counter" data-target="<?= $total ?>">0</p>
                                </div>
                                <div class="text-xl md:text-3xl opacity-40">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 text-white p-4 md:p-6 rounded-lg shadow-md hover:shadow-lg transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-green-100 text-xs md:text-sm font-medium">Diterima Magang</p>
                                    <p class="text-2xl md:text-4xl font-bold mt-2 md:mt-3 counter" data-target="<?= $diterima ?>">0</p>
                                </div>
                                <div class="text-xl md:text-3xl opacity-40">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card bg-gradient-to-br from-red-500 to-red-600 text-white p-4 md:p-6 rounded-lg shadow-md hover:shadow-lg transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-red-100 text-xs md:text-sm font-medium">Ditolak</p>
                                    <p class="text-2xl md:text-4xl font-bold mt-2 md:mt-3 counter" data-target="<?= $ditolak ?>">0</p>
                                </div>
                                <div class="text-xl md:text-3xl opacity-40">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card bg-gradient-to-br from-yellow-500 to-yellow-600 text-white p-4 md:p-6 rounded-lg shadow-md hover:shadow-lg transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-yellow-100 text-xs md:text-sm font-medium">Menunggu Persetujuan</p>
                                    <p class="text-2xl md:text-4xl font-bold mt-2 md:mt-3 counter" data-target="<?= $menunggu ?>">0</p>
                                </div>
                                <div class="text-xl md:text-3xl opacity-40">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                        <!-- Chart Nilai Evaluasi -->
                        <div class="chart-container bg-white rounded-lg shadow-sm border border-gray-200 p-6 md:p-8 hover:shadow-md transition">
                            <div class="chart-title">
                                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 flex items-center">
                                    <i class="fas fa-chart-bar mr-3 text-blue-600"></i>
                                    Rata-rata Nilai Evaluasi
                                </h3>
                                <p class="text-xs md:text-sm text-gray-600 mb-6">Statistik penilaian berdasarkan kriteria evaluasi</p>
                            </div>
                            <div class="chart-wrapper relative">
                                <canvas id="chartNilai" height="250"></canvas>
                            </div>
                        </div>

                        <!-- Chart Distribusi Status -->
                        <div class="chart-container bg-white rounded-lg shadow-sm border border-gray-200 p-6 md:p-8 hover:shadow-md transition">
                            <div class="chart-title">
                                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 flex items-center">
                                    <i class="fas fa-pie-chart mr-3 text-green-600"></i>
                                    Distribusi Status Pendaftaran
                                </h3>
                                <p class="text-xs md:text-sm text-gray-600 mb-6">Persentase distribusi status pendaftar magang</p>
                            </div>
                            <div class="chart-wrapper relative flex justify-center">
                                <canvas id="chartStatus" height="280"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Stats -->
                    <div class="summary-container mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6 md:p-8">
                        <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-chart-pie mr-3 text-purple-600"></i>
                            Ringkasan Nilai Evaluasi
                        </h3>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                            <div class="summary-card bg-gradient-to-br from-green-50 to-green-100 p-4 md:p-6 rounded-lg border border-green-200 hover:shadow-md transition">
                                <p class="text-xs md:text-sm text-gray-600 font-medium">Kehadiran</p>
                                <p class="text-2xl md:text-3xl font-bold text-green-600 mt-2 counter-decimal" data-target="<?= $kehadiran ?>">0</p>
                                <p class="text-xs text-gray-500 mt-1">dari 100</p>
                            </div>

                            <div class="summary-card bg-gradient-to-br from-blue-50 to-blue-100 p-4 md:p-6 rounded-lg border border-blue-200 hover:shadow-md transition">
                                <p class="text-xs md:text-sm text-gray-600 font-medium">Kinerja</p>
                                <p class="text-2xl md:text-3xl font-bold text-blue-600 mt-2 counter-decimal" data-target="<?= $kinerja ?>">0</p>
                                <p class="text-xs text-gray-500 mt-1">dari 100</p>
                            </div>

                            <div class="summary-card bg-gradient-to-br from-purple-50 to-purple-100 p-4 md:p-6 rounded-lg border border-purple-200 hover:shadow-md transition">
                                <p class="text-xs md:text-sm text-gray-600 font-medium">Sikap</p>
                                <p class="text-2xl md:text-3xl font-bold text-purple-600 mt-2 counter-decimal" data-target="<?= $sikap ?>">0</p>
                                <p class="text-xs text-gray-500 mt-1">dari 100</p>
                            </div>

                            <div class="summary-card bg-gradient-to-br from-yellow-50 to-yellow-100 p-4 md:p-6 rounded-lg border border-yellow-200 hover:shadow-md transition">
                                <p class="text-xs md:text-sm text-gray-600 font-medium">Nilai Akhir</p>
                                <p class="text-2xl md:text-3xl font-bold text-yellow-600 mt-2 counter-decimal" data-target="<?= $akhir ?>">0</p>
                                <p class="text-xs text-gray-500 mt-1">Rata-rata</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script dengan Animasi -->
    <script>
        // ==========================================
        //     ANIMASI NUMBER COUNTER
        // ==========================================
        function animateCounter() {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 1500;
                const start = Date.now();

                const updateCounter = () => {
                    const now = Date.now();
                    const progress = Math.min((now - start) / duration, 1);
                    
                    // Easing function: easeOutQuad
                    const easeProgress = 1 - Math.pow(1 - progress, 2);
                    const current = Math.floor(target * easeProgress);
                    
                    counter.textContent = current;
                    
                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };

                updateCounter();
            });

            const countersDecimal = document.querySelectorAll('.counter-decimal');
            countersDecimal.forEach(counter => {
                const target = parseFloat(counter.getAttribute('data-target'));
                const duration = 1500;
                const start = Date.now();

                const updateCounter = () => {
                    const now = Date.now();
                    const progress = Math.min((now - start) / duration, 1);
                    
                    // Easing function: easeOutQuad
                    const easeProgress = 1 - Math.pow(1 - progress, 2);
                    const current = (target * easeProgress).toFixed(1);
                    
                    counter.textContent = current;
                    
                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };

                updateCounter();
            });
        }

        // ==========================================
        //     CHART CONFIGURATION
        // ==========================================
        let chartNilai, chartStatus;

        function initCharts() {
            // ==========================================
            //     BAR CHART - ANIMATED DATA
            // ==========================================
            const chartNilaiCtx = document.getElementById('chartNilai').getContext('2d');
            
            // Data yang akan dianimasikan
            const barData = [<?= $kehadiran ?>, <?= $kinerja ?>, <?= $sikap ?>, <?= $akhir ?>];
            const animatedBarData = [0, 0, 0, 0];
            
            chartNilai = new Chart(chartNilaiCtx, {
                type: 'bar',
                data: {
                    labels: ['Kehadiran', 'Kinerja', 'Sikap', 'Nilai Akhir'],
                    datasets: [{
                        label: 'Rata-rata Nilai',
                        data: animatedBarData,
                        backgroundColor: ['#10B981', '#3B82F6', '#8B5CF6', '#F59E0B'],
                        borderRadius: 6,
                        borderWidth: 0,
                        barThickness: 'flex'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    animation: false,
                    plugins: { 
                        legend: { display: false }
                    },
                    scales: { 
                        y: { 
                            beginAtZero: true, 
                            max: 100,
                            ticks: { 
                                stepSize: 20,
                                font: { size: 11 }
                            },
                            grid: {
                                color: '#E5E7EB'
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 11 }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Animasi bar chart dari 0 ke nilai sebenarnya
            const barAnimationDuration = 1800;
            const barStartTime = Date.now();

            const animateBarChart = () => {
                const now = Date.now();
                const progress = Math.min((now - barStartTime) / barAnimationDuration, 1);
                
                // Easing function
                const easeProgress = 1 - Math.pow(1 - progress, 3);

                animatedBarData.forEach((val, index) => {
                    animatedBarData[index] = barData[index] * easeProgress;
                });

                chartNilai.data.datasets[0].data = animatedBarData;
                chartNilai.update('none');

                if (progress < 1) {
                    requestAnimationFrame(animateBarChart);
                } else {
                    // Pastikan nilai akhir tepat
                    chartNilai.data.datasets[0].data = barData;
                    chartNilai.update('none');
                }
            };

            setTimeout(() => {
                animateBarChart();
            }, 700);

            // ==========================================
            //     DOUGHNUT CHART - ANIMATED DATA
            // ==========================================
            const chartStatusCtx = document.getElementById('chartStatus').getContext('2d');
            
            const doughnutData = [<?= $diterima ?>, <?= $ditolak ?>, <?= $menunggu ?>];
            const animatedDoughnutData = [0, 0, 0];

            chartStatus = new Chart(chartStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Diterima', 'Ditolak', 'Menunggu'],
                    datasets: [{
                        data: animatedDoughnutData,
                        backgroundColor: ['#10B981', '#EF4444', '#F59E0B'],
                        borderWidth: 2,
                        borderColor: '#FFFFFF',
                        cutout: '65%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    animation: false,
                    plugins: { 
                        legend: { 
                            position: 'bottom',
                            labels: {
                                font: { size: 12 },
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });

            // Animasi doughnut chart dari 0 ke nilai sebenarnya
            const doughnutAnimationDuration = 2000;
            const doughnutStartTime = Date.now();

            const animateDoughnutChart = () => {
                const now = Date.now();
                const progress = Math.min((now - doughnutStartTime) / doughnutAnimationDuration, 1);
                
                // Easing function dengan bounce effect
                const easeProgress = 1 - Math.pow(1 - progress, 3);

                animatedDoughnutData.forEach((val, index) => {
                    animatedDoughnutData[index] = doughnutData[index] * easeProgress;
                });

                chartStatus.data.datasets[0].data = animatedDoughnutData;
                chartStatus.update('none');

                if (progress < 1) {
                    requestAnimationFrame(animateDoughnutChart);
                } else {
                    // Pastikan nilai akhir tepat
                    chartStatus.data.datasets[0].data = doughnutData;
                    chartStatus.update('none');
                }
            };

            setTimeout(() => {
                animateDoughnutChart();
            }, 800);
        }

        // ==========================================
        //     INIT SAAT PAGE LOAD
        // ==========================================
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi counter
            setTimeout(() => {
                animateCounter();
            }, 100);

            // Init chart dengan delay lebih lama untuk smooth animation
            setTimeout(() => {
                initCharts();
            }, 500);
        });
    </script>
</body>
</html>