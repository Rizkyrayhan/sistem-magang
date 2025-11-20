<?php
// views/admin/data-pendaftar.php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/helpers/helper.php';

// Proteksi: Harus login + harus admin
if (!isLoggedIn() || !isAdmin()) {
    redirect('login');
    exit;
}

$current = 'data-pendaftar';

// Ambil semua pendaftar
$pendaftar = $conn->query("
    SELECT p.*, u.nama, u.email 
    FROM pendaftar p 
    JOIN users u ON p.user_id = u.id 
    ORDER BY p.tanggal_daftar DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftar - LEMIGAS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .table-row:hover { background-color: #f8fafc; transition: all 0.2s; }
        .badge { font-size: 0.75rem; padding: 0.35rem 0.75rem; border-radius: 9999px; font-weight: 600; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <?php include 'partials/sidebar.php'; ?>

        <div class="flex-1 overflow-y-auto">
            <div class="p-8">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Data Pendaftar Magang</h1>
                        <p class="text-gray-600 mt-1">Kelola dan pantau seluruh pendaftar magang LEMIGAS</p>
                    </div>
                    <a href="<?= SITE_URL ?>admin/export-excel" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 transition">
                        <i class="fas fa-file-excel"></i>
                        <span>Export Excel</span>
                    </a>
                </div>

                <!-- Search & Filter -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
                    <input type="text" id="searchInput" placeholder="Cari nama, NIM, universitas..." class="w-full md:w-96 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select id="filterStatus" class="px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="proses">Sedang Magang</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <!-- Tabel Pendaftar -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full" id="tablePendaftar">
                            <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Mahasiswa</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Jurusan</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Universitas</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tgl Daftar</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php $no = 1; while ($p = $pendaftar->fetch_assoc()): ?>
                                <tr class="table-row">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= $no++ ?></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                <?php if ($p['pas_foto']): ?>
                                                    <img src="<?= file_url($p['pas_foto']) ?>" 
                                                         alt="Foto <?= htmlspecialchars($p['nama']) ?>"
                                                         class="w-12 h-12 rounded-full object-cover ring-4 ring-blue-100 shadow-md">
                                                <?php else: ?>
                                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                        <?= strtoupper(substr($p['nama'], 0, 1)) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900"><?= htmlspecialchars($p['nama']) ?></p>
                                                <p class="text-sm text-gray-500"><?= $p['nim'] ?: 'NIM belum diisi' ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($p['jurusan'] ?: '-') ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($p['universitas'] ?: '-') ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= formatTanggalFull($p['tanggal_daftar']) ?></td>
                                    <td class="px-6 py-4">
                                        <?= getBadgeStatus($p['status']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-3">
                                        <!-- LINK DETAIL SUDAH AMAN & TIDAK REDIRECT KE LOGIN -->
                                        <a href="<?= SITE_URL ?>admin/detail-pendaftar?id=<?= $p['id'] ?>" 
                                           class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>

                                        <?php if ($p['status'] === 'menunggu'): ?>
                                            <button onclick="ubahStatus(<?= $p['id'] ?>, 'diterima')" class="text-green-600 hover:text-green-800">
                                                <i class="fas fa-check-circle text-lg"></i>
                                            </button>
                                            <button onclick="ubahStatus(<?= $p['id'] ?>, 'ditolak')" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-times-circle text-lg"></i>
                                            </button>
                                        <?php endif; ?>
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

    <script>
        // Live Search & Filter
        const searchInput = document.getElementById('searchInput');
        const filterStatus = document.getElementById('filterStatus');
        const rows = document.querySelectorAll('#tablePendaftar tbody tr');

        function filterTable() {
            const query = searchInput.value.toLowerCase();
            const status = filterStatus.value;

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const rowStatus = row.querySelector('td:nth-child(6)')?.textContent.toLowerCase() || '';

                const matchSearch = text.includes(query);
                const matchStatus = !status || rowStatus.includes(status);

                row.style.display = matchSearch && matchStatus ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterStatus.addEventListener('change', filterTable);

        // Ubah Status
        async function ubahStatus(id, status) {
            if (!confirm(`Yakin ingin ${status === 'diterima' ? 'MENERIMA' : 'MENOLAK'} pendaftar ini?`)) return;

            const res = await fetch(`<?= SITE_URL ?>api/set-status?id=${id}&status=${status}`);
            const data = await res.json();

            alert(data.message);
            if (data.success) location.reload();
        }
    </script>
</body>
</html>