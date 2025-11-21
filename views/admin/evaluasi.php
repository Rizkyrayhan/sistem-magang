<?php
if (!isAdmin()) redirect('login');
$current = 'evaluasi';

$pendaftar_list = $conn->query("SELECT p.id, u.nama FROM pendaftar p JOIN users u ON p.user_id = u.id WHERE p.status = 'diterima'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluasi Magang - LEMIGAS</title>
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
                        <button id="sidebarToggle" class="md:hidden p-2 hover:bg-gray-100 rounded-lg transition text-gray-700">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                        
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Evaluasi Magang</h1>
                            <p class="text-xs md:text-sm text-gray-600 hidden md:block">Berikan penilaian untuk mahasiswa magang</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-4 md:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
                        <!-- Form Section -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 md:p-8">
                                <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Input Evaluasi Baru</h2>
                                <p class="text-sm text-gray-600 mb-6">Masukkan penilaian untuk mahasiswa yang sudah diterima</p>
                                
                                <form id="evaluasiForm" class="space-y-6">
                                    <!-- Pilih Mahasiswa -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-user-graduate mr-2 text-blue-600"></i>
                                            Pilih Mahasiswa
                                        </label>
                                        <select id="pendaftarId" required class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">-- Pilih Mahasiswa --</option>
                                            <?php while($row = $pendaftar_list->fetch_assoc()): ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nama']); ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <!-- Nilai Input Section -->
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700 mb-4">Masukkan Nilai (0-100)</p>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-xs md:text-sm font-medium text-gray-600 mb-2">
                                                    <i class="fas fa-clock mr-1 text-green-600"></i>
                                                    Nilai Kehadiran
                                                </label>
                                                <input type="number" id="nilaiKehadiran" min="0" max="100" required 
                                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                                       placeholder="0">
                                            </div>
                                            <div>
                                                <label class="block text-xs md:text-sm font-medium text-gray-600 mb-2">
                                                    <i class="fas fa-briefcase mr-1 text-blue-600"></i>
                                                    Nilai Kinerja
                                                </label>
                                                <input type="number" id="nilaiKinerja" min="0" max="100" required 
                                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="0">
                                            </div>
                                            <div>
                                                <label class="block text-xs md:text-sm font-medium text-gray-600 mb-2">
                                                    <i class="fas fa-heart mr-1 text-red-600"></i>
                                                    Nilai Sikap
                                                </label>
                                                <input type="number" id="nilaiSikap" min="0" max="100" required 
                                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                                       placeholder="0">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Komentar -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-comment-dots mr-2 text-purple-600"></i>
                                            Komentar (Opsional)
                                        </label>
                                        <textarea id="komentar" rows="4" 
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                                                  placeholder="Berikan komentar atau catatan tambahan untuk mahasiswa..."></textarea>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition shadow-md text-sm md:text-base">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Simpan Evaluasi
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Kriteria Section -->
                        <div>
                            <div class="bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-lg shadow-md p-6 md:p-8 sticky top-28">
                                <h3 class="text-lg md:text-xl font-bold mb-6 flex items-center">
                                    <i class="fas fa-info-circle mr-3 text-blue-200"></i>
                                    Kriteria Penilaian
                                </h3>
                                
                                <div class="space-y-5">
                                    <div class="pb-5 border-b border-blue-500">
                                        <p class="font-semibold text-sm md:text-base mb-2 flex items-center">
                                            <span class="w-6 h-6 bg-green-400 rounded-full flex items-center justify-center text-xs font-bold mr-3">1</span>
                                            Nilai Kehadiran
                                        </p>
                                        <p class="text-xs md:text-sm text-blue-100 ml-9">Tingkat kehadiran dan ketepatan waktu mahasiswa selama magang berlangsung</p>
                                    </div>

                                    <div class="pb-5 border-b border-blue-500">
                                        <p class="font-semibold text-sm md:text-base mb-2 flex items-center">
                                            <span class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center text-xs font-bold text-gray-900 mr-3">2</span>
                                            Nilai Kinerja
                                        </p>
                                        <p class="text-xs md:text-sm text-blue-100 ml-9">Kualitas pekerjaan dan pencapaian target yang telah diberikan</p>
                                    </div>

                                    <div class="pb-5">
                                        <p class="font-semibold text-sm md:text-base mb-2 flex items-center">
                                            <span class="w-6 h-6 bg-red-400 rounded-full flex items-center justify-center text-xs font-bold text-white mr-3">3</span>
                                            Nilai Sikap
                                        </p>
                                        <p class="text-xs md:text-sm text-blue-100 ml-9">Etika kerja, kerjasama tim, dan perilaku profesional</p>
                                    </div>
                                </div>

                                <div class="bg-blue-500 bg-opacity-50 p-4 rounded-lg mt-6 border-l-4 border-blue-300">
                                    <p class="text-xs md:text-sm text-blue-50">
                                        <i class="fas fa-lightbulb mr-2"></i>
                                        <strong>Catatan:</strong> Nilai akhir akan dihitung otomatis sebagai rata-rata dari ketiga komponen penilaian
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('evaluasiForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const pendaftarId = document.getElementById('pendaftarId').value;
            if (!pendaftarId) {
                alert('Silakan pilih mahasiswa terlebih dahulu');
                return;
            }

            const nilaiKehadiran = parseInt(document.getElementById('nilaiKehadiran').value);
            const nilaiKinerja = parseInt(document.getElementById('nilaiKinerja').value);
            const nilaiSikap = parseInt(document.getElementById('nilaiSikap').value);

            if (isNaN(nilaiKehadiran) || isNaN(nilaiKinerja) || isNaN(nilaiSikap)) {
                alert('Semua nilai harus diisi dengan angka');
                return;
            }

            const data = {
                pendaftar_id: pendaftarId,
                nilai_kehadiran: nilaiKehadiran,
                nilai_kinerja: nilaiKinerja,
                nilai_sikap: nilaiSikap,
                komentar: document.getElementById('komentar').value.trim()
            };

            try {
                const response = await fetch('<?= SITE_URL ?>api/simpan-evaluasi', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                
                alert(result.success ? '✅ ' + result.message : '❌ ' + result.message);

                if (result.success) {
                    this.reset();
                    document.getElementById('pendaftarId').focus();
                }
            } catch (err) {
                alert('Gagal mengirim data. Periksa koneksi internet.');
                console.error(err);
            }
        });
    </script>
</body>
</html>