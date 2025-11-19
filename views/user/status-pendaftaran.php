<?php
if (!isLoggedIn() || !isPendaftar()) {
    redirect('login');
}

$user = getCurrentUser();
$pendaftar = getPendaftar($conn, $user['id']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftaran - LEMIGAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="flex">
        <!-- Sidebar (sama seperti user dashboard) -->
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
                <a href="<?php echo SITE_URL; ?>user/dashboard" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo SITE_URL; ?>user/status-pendaftaran" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-medium">
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
                    <h2 class="text-3xl font-bold mb-2">Status Pendaftaran</h2>
                    <p class="text-blue-100">Kelola informasi pendaftaran magang Anda</p>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="max-w-3xl">
                    <!-- Status Timeline -->
                    <div class="bg-white rounded-lg shadow p-8 mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-6">Timeline Status</h3>
                        <div class="space-y-6">
                            <!-- Step 1 -->
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold text-sm">1</div>
                                    <div class="w-1 h-16 bg-blue-200 mt-2"></div>
                                </div>
                                <div class="pb-6">
                                    <p class="font-semibold text-gray-800">Pendaftaran Dikirim</p>
                                    <p class="text-gray-600 text-sm mt-1"><?php echo formatTanggalFull($pendaftar['tanggal_daftar']); ?></p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 <?php echo in_array($pendaftar['status'], ['diterima', 'proses', 'ditolak']) ? 'bg-blue-500' : 'bg-gray-300'; ?> text-white rounded-full flex items-center justify-center font-bold text-sm">2</div>
                                    <div class="w-1 h-16 <?php echo in_array($pendaftar['status'], ['proses']) ? 'bg-blue-200' : 'bg-gray-200'; ?> mt-2"></div>
                                </div>
                                <div class="pb-6">
                                    <p class="font-semibold <?php echo in_array($pendaftar['status'], ['diterima', 'proses', 'ditolak']) ? 'text-gray-800' : 'text-gray-400'; ?>">Review Pendaftaran</p>
                                    <p class="text-gray-600 text-sm mt-1">Status: 
                                        <?php 
                                            if ($pendaftar['status'] === 'menunggu') echo '<span class="font-medium text-yellow-600">Menunggu Review</span>';
                                            else if ($pendaftar['status'] === 'diterima') echo '<span class="font-medium text-green-600">Diterima ✓</span>';
                                            else if ($pendaftar['status'] === 'ditolak') echo '<span class="font-medium text-red-600">Ditolak ✗</span>';
                                            else if ($pendaftar['status'] === 'proses') echo '<span class="font-medium text-blue-600">Proses</span>';
                                        ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 <?php echo $pendaftar['status'] === 'proses' ? 'bg-blue-500' : 'bg-gray-300'; ?> text-white rounded-full flex items-center justify-center font-bold text-sm">3</div>
                                </div>
                                <div class="pb-6">
                                    <p class="font-semibold <?php echo $pendaftar['status'] === 'proses' ? 'text-gray-800' : 'text-gray-400'; ?>">Pelaksanaan Magang</p>
                                    <p class="text-gray-600 text-sm mt-1"><?php echo $pendaftar['status'] === 'proses' ? 'Sedang berjalan' : 'Menunggu...'; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Edit Data -->
                    <div class="bg-white rounded-lg shadow p-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-6">Form Data Pendaftar</h3>
                        
                        <div id="alert" class="hidden mb-4 p-4 rounded-lg"></div>

                        <form id="formPendaftar" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                                    <input type="text" id="nim" value="<?php echo $pendaftar['nim'] ?: ''; ?>"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="2021001234">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat, Tanggal Lahir</label>
                                    <input type="text" id="tempatTanggalLahir" value="<?php echo $pendaftar['tempat_tanggal_lahir'] ?: ''; ?>"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Jakarta, 1 Januari 2000">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan</label>
                                    <input type="text" id="jurusan" value="<?php echo $pendaftar['jurusan'] ?: ''; ?>"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Teknik Informatika">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Universitas</label>
                                    <input type="text" id="universitas" value="<?php echo $pendaftar['universitas'] ?: ''; ?>"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Universitas Indonesia">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bidang Minat</label>
                                    <input type="text" id="bidangMinat" value="<?php echo $pendaftar['bidang_minat'] ?: ''; ?>"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Oil & Gas Technology">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                                    <input type="tel" id="noHp" value="<?php echo $pendaftar['no_hp'] ?: ''; ?>"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="08xx xxxx xxxx">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <textarea id="alamat" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Jalan..."><?php echo $pendaftar['alamat'] ?: ''; ?></textarea>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('formPendaftar').addEventListener('submit', async (e) => {
            e.preventDefault();

            const data = {
                nim: document.getElementById('nim').value,
                tempat_tanggal_lahir: document.getElementById('tempatTanggalLahir').value,
                jurusan: document.getElementById('jurusan').value,
                universitas: document.getElementById('universitas').value,
                bidang_minat: document.getElementById('bidangMinat').value,
                no_hp: document.getElementById('noHp').value,
                alamat: document.getElementById('alamat').value,
            };

            const alert = document.getElementById('alert');

            try {
                const response = await fetch('<?php echo SITE_URL; ?>api/tambah-pendaftar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    alert.className = 'mb-4 p-4 rounded-lg bg-green-100 text-green-700';
                    alert.textContent = result.message;
                    alert.classList.remove('hidden');
                } else {
                    alert.className = 'mb-4 p-4 rounded-lg bg-red-100 text-red-700';
                    alert.textContent = result.message;
                    alert.classList.remove('hidden');
                }
            } catch (error) {
                alert.className = 'mb-4 p-4 rounded-lg bg-red-100 text-red-700';
                alert.textContent = 'Terjadi kesalahan: ' + error.message;
                alert.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>