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
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Data Pendaftar</h1>
                            <p class="text-xs md:text-sm text-gray-600 hidden md:block">Kelola seluruh pendaftar magang LEMIGAS</p>
                        </div>
                    </div>

                    <a href="<?= SITE_URL ?>admin/export-excel" class="hidden md:flex bg-green-600 hover:bg-green-700 text-white font-semibold px-4 md:px-6 py-2 md:py-3 rounded-lg shadow-md flex items-center gap-2 text-sm transition">
                        <i class="fas fa-file-excel"></i>
                        <span class="hidden lg:inline">Export Excel</span>
                    </a>
                </div>
            </div>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-4 md:p-8">
                    <!-- Search & Filter -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6 mb-6">
                        <div class="flex flex-col md:flex-row gap-3 md:gap-4">
                            <input type="text" id="searchInput" placeholder="Cari nama, NIM, universitas..." 
                                   class="flex-1 px-4 py-2 md:py-3 border border-gray-300 rounded-lg text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <select id="filterStatus" class="px-4 py-2 md:py-3 border border-gray-300 rounded-lg text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="diterima">Diterima</option>
                                <option value="ditolak">Ditolak</option>
                                <option value="proses">Sedang Magang</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table Pendaftar -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs md:text-sm" id="tablePendaftar">
                                <thead class="bg-blue-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-3 md:px-6 py-3 md:py-4 text-left font-semibold text-gray-700">No</th>
                                        <th class="px-3 md:px-6 py-3 md:py-4 text-left font-semibold text-gray-700">Mahasiswa</th>
                                        <th class="px-3 md:px-6 py-3 md:py-4 text-left font-semibold text-gray-700 hidden md:table-cell">Jurusan</th>
                                        <th class="px-3 md:px-6 py-3 md:py-4 text-left font-semibold text-gray-700 hidden lg:table-cell">Universitas</th>
                                        <th class="px-3 md:px-6 py-3 md:py-4 text-left font-semibold text-gray-700 hidden sm:table-cell">Tgl Daftar</th>
                                        <th class="px-3 md:px-6 py-3 md:py-4 text-left font-semibold text-gray-700">Status</th>
                                        <th class="px-3 md:px-6 py-3 md:py-4 text-center font-semibold text-gray-700">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php $no = 1; while ($p = $pendaftar->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-50 transition table-row">
                                        <td class="px-3 md:px-6 py-3 md:py-4 font-medium text-gray-900"><?= $no++ ?></td>

                                        <td class="px-3 md:px-6 py-3 md:py-4">
                                            <div class="flex items-center gap-2 md:gap-3">
                                                <div class="flex-shrink-0">
                                                    <?php if ($p['pas_foto']): ?>
                                                        <img src="<?= file_url($p['pas_foto']) ?>" 
                                                             alt="<?= htmlspecialchars($p['nama']) ?>"
                                                             class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover">
                                                    <?php else: ?>
                                                        <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xs md:text-sm">
                                                            <?= strtoupper(substr($p['nama'], 0, 1)) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-semibold text-gray-900 text-xs md:text-sm truncate"><?= htmlspecialchars($p['nama']) ?></p>
                                                    <p class="text-xs text-gray-500 truncate"><?= $p['nim'] ?: 'NIM belum diisi' ?></p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-3 md:px-6 py-3 md:py-4 text-gray-700 hidden md:table-cell text-xs md:text-sm"><?= htmlspecialchars($p['jurusan'] ?: '-') ?></td>
                                        <td class="px-3 md:px-6 py-3 md:py-4 text-gray-700 hidden lg:table-cell text-xs md:text-sm"><?= htmlspecialchars($p['universitas'] ?: '-') ?></td>
                                        <td class="px-3 md:px-6 py-3 md:py-4 text-gray-600 hidden sm:table-cell text-xs md:text-sm"><?= formatTanggalFull($p['tanggal_daftar']) ?></td>

                                        <td class="px-3 md:px-6 py-3 md:py-4">
                                            <?= getBadgeStatus($p['status']) ?>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-3 md:px-6 py-3 md:py-4">
                                            <div class="flex items-center justify-center gap-1 md:gap-2">
                                                <!-- Detail Button -->
                                                <a href="<?= SITE_URL ?>admin/detail-pendaftar?id=<?= $p['id'] ?>" 
                                                   class="p-2 text-blue-600 hover:bg-blue-100 rounded transition text-xs md:text-sm" 
                                                   title="Lihat detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <!-- Status Dropdown -->
                                                <div class="relative inline-block">
                                                    <button class="p-2 text-gray-600 hover:bg-gray-100 rounded transition text-xs md:text-sm"
                                                            onclick="toggleDropdown(<?= $p['id'] ?>)"
                                                            title="Ubah status">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <!-- Dropdown Menu -->
                                                    <div id="dropdown-<?= $p['id'] ?>" 
                                                         class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg border border-gray-200 rounded-lg z-50">
                                                        <button onclick="ubahStatus(<?= $p['id'] ?>, 'menunggu')"
                                                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 transition">
                                                            <i class="fas fa-hourglass text-yellow-500 mr-2"></i>Menunggu
                                                        </button>
                                                        <button onclick="ubahStatus(<?= $p['id'] ?>, 'diterima')"
                                                                class="block w-full text-left px-4 py-2 text-sm hover:bg-green-50 transition">
                                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>Diterima
                                                        </button>
                                                        <button onclick="ubahStatus(<?= $p['id'] ?>, 'ditolak')"
                                                                class="block w-full text-left px-4 py-2 text-sm hover:bg-red-50 transition">
                                                            <i class="fas fa-times-circle text-red-500 mr-2"></i>Ditolak
                                                        </button>
                                                        <button onclick="ubahStatus(<?= $p['id'] ?>, 'proses')"
                                                                class="block w-full text-left px-4 py-2 text-sm hover:bg-blue-50 transition">
                                                            <i class="fas fa-spinner text-blue-500 mr-2"></i>Sedang Magang
                                                        </button>
                                                        <button onclick="ubahStatus(<?= $p['id'] ?>, 'selesai')"
                                                                class="block w-full text-left px-4 py-2 text-sm hover:bg-purple-50 transition">
                                                            <i class="fas fa-flag-checkered text-purple-500 mr-2"></i>Selesai
                                                        </button>
                                                        <div class="border-t border-gray-100 my-2"></div>
                                                        <button onclick="deletePendaftar(<?= $p['id'] ?>)"
                                                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                                            <i class="fas fa-trash-alt text-red-600 mr-2"></i>Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
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
        // ==========================================
        //     LIVE SEARCH & FILTER
        // ==========================================
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

        // ==========================================
        //     DROPDOWN TOGGLE
        // ==========================================
        function toggleDropdown(id) {
            const dropdown = document.getElementById("dropdown-" + id);
            const allDropdowns = document.querySelectorAll("[id^='dropdown-']");
            
            allDropdowns.forEach(el => {
                if (el.id !== "dropdown-" + id) {
                    el.classList.add("hidden");
                }
            });

            dropdown.classList.toggle("hidden");
        }

        // Close dropdown when clicking outside
        document.addEventListener("click", function(e) {
            if (!e.target.closest("[id^='dropdown-']") && !e.target.closest("button[onclick*='toggleDropdown']")) {
                document.querySelectorAll("[id^='dropdown-']").forEach(el => {
                    el.classList.add("hidden");
                });
            }
        });

        // ==========================================
        //     UBAH STATUS - AJAX
        // ==========================================
        async function ubahStatus(id, status) {
            const statusLabel = {
                'menunggu': 'Menunggu',
                'diterima': 'Diterima',
                'ditolak': 'Ditolak',
                'proses': 'Sedang Magang',
                'selesai': 'Selesai'
            };

            if (!confirm(`Yakin ingin mengubah status menjadi: ${statusLabel[status]}?`)) return;

            try {
                const res = await fetch(`<?= SITE_URL ?>api/set-status?id=${id}&status=${status}`);
                const data = await res.json();

                alert(data.message);
                if (data.success) location.reload();
            } catch (err) {
                alert('Gagal mengubah status. Periksa koneksi internet.');
                console.error(err);
            }
        }

        // ==========================================
        //     DELETE PENDAFTAR - AJAX
        // ==========================================
        async function deletePendaftar(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus pendaftar ini? Tindakan ini tidak dapat dibatalkan.')) return;

            try {
                const res = await fetch(`<?= SITE_URL ?>api/delete-pendaftar?id=${id}`, {
                    method: 'DELETE'
                });
                const data = await res.json();

                alert(data.message);
                if (data.success) location.reload();
            } catch (err) {
                alert('Gagal menghapus pendaftar. Periksa koneksi internet.');
                console.error(err);
            }
        }
    </script>

</body>
</html>