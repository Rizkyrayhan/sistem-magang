<?php
// session_start();
// require_once '../../config.php';
// require_once '../../src/helpers/helper.php';

if (!isAdmin()) redirect('login');

$pendaftar_list = getAllPendaftar($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluasi Magang - LEMIGAS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg min-h-screen">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v2H4V4zm0 7h16v2H4v-2zm0 7h16v2H4v-2z"/></svg>
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
                <a href="<?php echo SITE_URL; ?>admin/evaluasi" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/></svg>
                    <span>Evaluasi</span>
                </a>
                <a href="<?php echo SITE_URL; ?>admin/laporan" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
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
                <h2 class="text-2xl font-bold text-gray-800">Evaluasi Magang</h2>
                <p class="text-gray-600 text-sm">Berikan penilaian untuk mahasiswa magang</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- List Pendaftar -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="font-bold text-gray-800">Daftar Peserta</h3>
                        </div>
                        <div class="overflow-y-auto max-h-96">
                            <?php foreach ($pendaftar_list as $p): ?>
                            <button onclick="selectPendaftar(<?php echo $p['id']; ?>, '<?php echo addslashes($p['nama']); ?>')"
                                    class="w-full text-left px-6 py-3 border-b border-gray-100 hover:bg-blue-50 transition">
                                <p class="font-medium text-gray-800 text-sm"><?php echo $p['nama']; ?></p>
                                <p class="text-gray-600 text-xs mt-1"><?php echo $p['email']; ?></p>
                            </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Form Evaluasi -->
                    <div class="md:col-span-2">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-6">Form Evaluasi</h3>
                            
                            <div id="emptyState" class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                </svg>
                                <p class="text-gray-500">Pilih peserta dari daftar untuk memulai evaluasi</p>
                            </div>

                            <form id="evaluasiForm" class="hidden space-y-6">
                                <input type="hidden" id="pendaftarId">
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Peserta</label>
                                    <input type="text" id="namaPeserta" readonly 
                                           class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-800">
                                </div>

                                <div class="bg-blue-50 rounded-lg p-6">
                                    <p class="text-sm text-blue-900 font-semibold mb-4">Kriteria Penilaian</p>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Nilai Kehadiran (0-100)
                                                <span class="text-gray-500 text-xs ml-2" id="nilaiKehadiranDisplay">-</span>
                                            </label>
                                            <input type="range" id="nilaiKehadiran" min="0" max="100" value="0"
                                                   class="w-full cursor-pointer"
                                                   oninput="updateDisplay('nilaiKehadiran')">
                                            <div class="flex justify-between text-xs text-gray-600 mt-1">
                                                <span>Rendah</span>
                                                <span>Sedang</span>
                                                <span>Tinggi</span>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Nilai Kinerja (0-100)
                                                <span class="text-gray-500 text-xs ml-2" id="nilaiKinerjaDisplay">-</span>
                                            </label>
                                            <input type="range" id="nilaiKinerja" min="0" max="100" value="0"
                                                   class="w-full cursor-pointer"
                                                   oninput="updateDisplay('nilaiKinerja')">
                                            <div class="flex justify-between text-xs text-gray-600 mt-1">
                                                <span>Rendah</span>
                                                <span>Sedang</span>
                                                <span>Tinggi</span>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Nilai Sikap (0-100)
                                                <span class="text-gray-500 text-xs ml-2" id="nilaiSikapDisplay">-</span>
                                            </label>
                                            <input type="range" id="nilaiSikap" min="0" max="100" value="0"
                                                   class="w-full cursor-pointer"
                                                   oninput="updateDisplay('nilaiSikap')">
                                            <div class="flex justify-between text-xs text-gray-600 mt-1">
                                                <span>Rendah</span>
                                                <span>Sedang</span>
                                                <span>Tinggi</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-4 border-t border-blue-200">
                                        <p class="text-sm text-blue-900">
                                            <span class="font-semibold">Rata-rata Nilai:</span> 
                                            <span id="rataRata" class="text-lg font-bold">0.00</span>
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                                    <textarea id="komentar" rows="4"
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                              placeholder="Berikan komentar atau catatan untuk peserta..."></textarea>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">
                                    Simpan Evaluasi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectPendaftar(id, nama) {
            document.getElementById('pendaftarId').value = id;
            document.getElementById('namaPeserta').value = nama;
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('evaluasiForm').classList.remove('hidden');
            
            // Reset form
            document.getElementById('nilaiKehadiran').value = 0;
            document.getElementById('nilaiKinerja').value = 0;
            document.getElementById('nilaiSikap').value = 0;
            updateDisplay('nilaiKehadiran');
            updateDisplay('nilaiKinerja');
            updateDisplay('nilaiSikap');
        }

        function updateDisplay(fieldId) {
            const value = document.getElementById(fieldId).value;
            document.getElementById(fieldId + 'Display').textContent = value;
            
            const kehadiran = parseFloat(document.getElementById('nilaiKehadiran').value);
            const kinerja = parseFloat(document.getElementById('nilaiKinerja').value);
            const sikap = parseFloat(document.getElementById('nilaiSikap').value);
            
            const rataRata = (kehadiran + kinerja + sikap) / 3;
            document.getElementById('rataRata').textContent = rataRata.toFixed(2);
        }

        document.getElementById('evaluasiForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const pendaftarId = document.getElementById('pendaftarId').value;
            const nilaiKehadiran = document.getElementById('nilaiKehadiran').value;
            const nilaiKinerja = document.getElementById('nilaiKinerja').value;
            const nilaiSikap = document.getElementById('nilaiSikap').value;
            const komentar = document.getElementById('komentar').value;

            try {
                const response = await fetch('<?php echo SITE_URL; ?>api/simpan-evaluasi', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        pendaftar_id: pendaftarId,
                        nilai_kehadiran: nilaiKehadiran,
                        nilai_kinerja: nilaiKinerja,
                        nilai_sikap: nilaiSikap,
                        komentar: komentar
                    })
                });

                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    document.getElementById('evaluasiForm').reset();
                    document.getElementById('emptyState').classList.remove('hidden');
                    document.getElementById('evaluasiForm').classList.add('hidden');
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                alert('Terjadi kesalahan: ' + error.message);
            }
        });
    </script>
</body>
</html>