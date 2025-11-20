<?php
if (!isAdmin()) redirect('login');
$current = 'evaluasi'; // untuk active menu sidebar

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
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar sama seperti dashboard.php -->

                <?php include 'partials/sidebar.php'; ?>
        <div class="flex-1 overflow-y-auto p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Evaluasi Magang</h1>
            <p class="text-gray-600 mb-8">Berikan penilaian untuk mahasiswa magang</p>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-xl font-bold mb-6">Input Evaluasi Baru</h2>
                        <form id="evaluasiForm">
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Mahasiswa</label>
                                <select id="pendaftarId" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Pilih Mahasiswa --</option>
                                    <?php while($row = $pendaftar_list->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Kehadiran (0-100)</label>
                                    <input type="number" id="nilaiKehadiran" min="0" max="100" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Kinerja (0-100)</label>
                                    <input type="number" id="nilaiKinerja" min="0" max="100" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Sikap (0-100)</label>
                                    <input type="number" id="nilaiSikap" min="0" max="100" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                                <textarea id="komentar" rows="4" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Berikan komentar atau catatan untuk mahasiswa..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-lg hover:bg-blue-700">
                                Simpan Evaluasi
                            </button>
                        </form>
                    </div>
                </div>

                <div>
                    <div class="bg-blue-600 text-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold mb-6">Kriteria Penilaian</h2>
                        <div class="space-y-6">
                            <div>
                                <h3 class="font-bold text-lg">Nilai Kehadiran</h3>
                                <p class="text-sm opacity-90">Tingkat kehadiran dan ketepatan waktu mahasiswa selama magang</p>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg">Nilai Kinerja</h3>
                                <p class="text-sm opacity-90">Kualitas pekerjaan dan pencapaian target yang diberikan</p>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg">Nilai Sikap</h3>
                                <p class="text-sm opacity-90">Etika kerja, kerjasama tim, dan perilaku profesional</p>
                            </div>
                            <div class="bg-blue-700 p-4 rounded-lg mt-6">
                                <p class="text-sm">Catatan: Nilai akhir akan dihitung otomatis sebagai rata-rata dari ketiga komponen penilaian</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- AJAX Script -->
    <script>
    document.getElementById('evaluasiForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const data = {
            pendaftar_id: document.getElementById('pendaftarId').value,
            nilai_kehadiran: parseInt(document.getElementById('nilaiKehadiran').value),
            nilai_kinerja: parseInt(document.getElementById('nilaiKinerja').value),
            nilai_sikap: parseInt(document.getElementById('nilaiSikap').value),
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