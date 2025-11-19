<?php
// session_start();
// require_once '../../config.php';
// require_once '../../src/helpers/helper.php';

if (!isAdmin()) redirect('login');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftar - LEMIGAS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="flex">
        <!-- Sidebar (sama seperti dashboard) -->
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
                <a href="<?php echo SITE_URL; ?>admin/data-pendaftar" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Data Pendaftar</span>
                </a>
                <a href="<?php echo SITE_URL; ?>admin/evaluasi" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
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
                <h2 class="text-2xl font-bold text-gray-800">Data Pendaftar</h2>
                <p class="text-gray-600 text-sm">Kelola data mahasiswa yang mendaftar magang</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Filter & Search -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex flex-col md:flex-row gap-4">
                        <input type="text" id="search" placeholder="Cari nama, email, atau NIM..." 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="semua">Semua Status</option>
                            <option value="menunggu">Menunggu Review</option>
                            <option value="diterima">Diterima</option>
                            <option value="proses">Sedang Magang</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                        <button onclick="loadPendaftar()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Filter</button>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">NO</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Nama</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">NIM</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Jurusan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Universitas</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <tr><td colspan="7" class="text-center py-4 text-gray-500">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div id="modalDetail" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-96 overflow-y-auto">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Detail Pendaftar</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">✕</button>
            </div>
            <div id="modalContent" class="p-6 space-y-3">
                <!-- Content akan diisi oleh JavaScript -->
            </div>
            <div class="p-6 border-t border-gray-200 flex gap-2">
                <select id="statusSelect" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="menunggu">Menunggu Review</option>
                    <option value="diterima">Diterima</option>
                    <option value="proses">Sedang Magang</option>
                    <option value="ditolak">Ditolak</option>
                </select>
                <button onclick="updateStatus()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update Status</button>
                <button onclick="closeModal()" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        let currentPendaftarId = null;

        document.getElementById('statusFilter').addEventListener('change', loadPendaftar);
        document.getElementById('search').addEventListener('keyup', loadPendaftar);

        async function loadPendaftar() {
            const search = document.getElementById('search').value;
            const status = document.getElementById('statusFilter').value;
            
            try {
                const response = await fetch(`<?php echo SITE_URL; ?>api/get-pendaftar?search=${search}&status=${status}`);
                const data = await response.json();
                
                if (data.success) {
                    renderTable(data.data.pendaftar);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function renderTable(pendaftar) {
            const tbody = document.getElementById('tableBody');
            
            if (pendaftar.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-gray-500">Tidak ada data</td></tr>';
                return;
            }

            tbody.innerHTML = pendaftar.map((p, idx) => `
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-800">${idx + 1}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">${p.nama}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">${p.nim || '-'}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">${p.jurusan || '-'}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">${p.universitas || '-'}</td>
                    <td class="px-6 py-4 text-sm">${getBadgeStatus(p.status)}</td>
                    <td class="px-6 py-4 text-sm">
                        <button onclick="showDetail(${p.id}, '${p.status}')" class="text-blue-600 hover:text-blue-700 font-medium">Detail</button>
                    </td>
                </tr>
            `).join('');
        }

        function showDetail(id, status) {
            currentPendaftarId = id;
            document.getElementById('statusSelect').value = status;
            document.getElementById('modalDetail').classList.remove('hidden');
            // Load and display detail
        }

        function closeModal() {
            document.getElementById('modalDetail').classList.add('hidden');
        }

        async function updateStatus() {
            const status = document.getElementById('statusSelect').value;
            // Call update API here
            alert('Update status functionality coming soon');
            closeModal();
            loadPendaftar();
        }

        function getBadgeStatus(status) {
            const badges = {
                'menunggu': '<span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Menunggu</span>',
                'diterima': '<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Diterima</span>',
                'ditolak': '<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Ditolak</span>',
                'proses': '<span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Proses</span>',
            };
            return badges[status] || '';
        }

        loadPendaftar();
    </script>
</body>
</html>