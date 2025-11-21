<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/helpers/helper.php';

if (!isLoggedIn() || !isPendaftar()) {
    redirect('login');
}

$user = getCurrentUser();
$pendaftar = getPendaftar($conn, $user['id']) ?: [];
$current = 'status';

// Ambil data universitas dan bidang minat dari database
$universitas_list = getUniversitasGrouped($conn);
$bidang_minat_list = getBidangMinatGrouped($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Diri - LEMIGAS Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
        }

        .main-wrapper {
            display: flex;
            gap: 0;
        }

        /* CSS untuk menggeser konten utama (Main Content Area) */
        .main-content-area {
            flex-grow: 1; 
            min-height: 100vh;
            overflow-y: auto;
            transition: margin-left 0.3s ease;
        }
        
        @media (min-width: 1025px) {
            .main-content-area {
                margin-left: 280px; /* Lebar sidebar */
            }
        }

        /* CSS untuk menyembunyikan tombol toggle saat sidebar aktif (mobile) */
        .toggle-sidebar.active {
            display: none !important;
        }
        
        /* Sisanya tetap sama */

        .header-formal {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e40af 100%);
            border-bottom: 4px solid #3b82f6;
        }

        .form-section {
            border-left: 4px solid #3b82f6;
        }

        .form-label {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input, .form-select, .form-textarea {
            border: 1px solid #d1d5db;
            transition: all 0.3s ease;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.125rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .section-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #3b82f6;
            color: white;
            border-radius: 8px;
        }

        .file-upload-label {
            display: block;
            padding: 2rem;
            border: 2px dashed #d1d5db;
            border-radius: 0.75rem;
            background-color: #f9fafb;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
        }

        .file-upload-label:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        /* Autocomplete Styles */
        .autocomplete-container {
            position: relative;
            width: 100%;
        }

        .autocomplete-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .autocomplete-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .autocomplete-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid #d1d5db;
            border-top: none;
            border-radius: 0 0 0.5rem 0.5rem;
            max-height: 300px;
            overflow-y: auto;
            z-index: 10;
            display: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .autocomplete-list.active {
            display: block;
        }

        .autocomplete-group {
            padding: 0.5rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .autocomplete-group:last-child {
            border-bottom: none;
        }

        .autocomplete-group-title {
            padding: 0.5rem 1rem;
            background-color: #f3f4f6;
            font-weight: 600;
            color: #374151;
            font-size: 0.875rem;
            text-transform: uppercase;
        }

        .autocomplete-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            color: #374151;
            transition: background-color 0.2s;
        }

        .autocomplete-item:hover {
            background-color: #eff6ff;
            color: #1e40af;
        }

        .autocomplete-item.selected {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .autocomplete-item-highlight {
            font-weight: 600;
            color: #3b82f6;
        }

        .no-results {
            padding: 1rem;
            text-align: center;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <div class="main-content-area">
            <div class="toggle-sidebar fixed top-4 left-4 z-50" id="toggleSidebarBtn">
                <button onclick="document.querySelector('.sidebar').classList.toggle('active'); document.getElementById('sidebarOverlay').classList.toggle('active');" 
                        class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg shadow-lg transition">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <div class="header-formal text-white p-6 md:p-8">
                <div class="max-w-6xl mx-auto">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="bg-blue-400 bg-opacity-20 p-3 rounded-lg">
                            <i class="fas fa-file-alt text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-blue-100 text-sm font-semibold">FORMULIR PENDAFTARAN</p>
                            <h1 class="text-2xl md:text-3xl font-bold">Data Diri & Dokumen Pendukung</h1>
                        </div>
                    </div>
                    <p class="text-blue-100 text-sm">Lengkapi informasi pribadi, pendidikan, dan dokumen yang diperlukan</p>
                </div>
            </div>

            <div class="max-w-5xl mx-auto px-4 md:px-8 py-8">
                <div id="alert" class="hidden mb-8 p-4 rounded-lg text-white font-medium text-center shadow-md"></div>

                <form id="formPendaftar" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md overflow-hidden">
                    
                    <div class="p-6 md:p-8 border-b border-gray-200">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>Data Pribadi</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label block mb-2">Nama Lengkap</label>
                                <input type="text" value="<?= htmlspecialchars($user['nama']) ?>" disabled class="form-input w-full px-4 py-3 border rounded-lg bg-gray-50 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="form-label block mb-2">Email</label>
                                <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled class="form-input w-full px-4 py-3 border rounded-lg bg-gray-50 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="form-label block mb-2">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($pendaftar['tempat_lahir'] ?? '') ?>" placeholder="Jakarta" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div>
                                <label class="form-label block mb-2">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($pendaftar['tanggal_lahir'] ?? '') ?>" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div>
                                <label class="form-label block mb-2">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select w-full px-4 py-3 border rounded-lg bg-white">
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" <?= ($pendaftar['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= ($pendaftar['jenis_kelamin'] ?? '') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label block mb-2">No. HP / WhatsApp</label>
                                <input type="text" name="no_hp" value="<?= htmlspecialchars($pendaftar['no_hp'] ?? '') ?>" placeholder="08123456789" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div class="md:col-span-2">
                                <label class="form-label block mb-2">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" placeholder="Jl. Raya No. 123..." class="form-textarea w-full px-4 py-3 border rounded-lg resize-none"><?= htmlspecialchars($pendaftar['alamat'] ?? '') ?></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="form-label block mb-3">Pas Foto <span class="text-red-500">*</span></label>
                                <label class="file-upload-label">
                                    <input type="file" name="foto" accept=".jpg,.jpeg,.png" class="hidden">
                                    <div>
                                        <i class="fas fa-cloud-upload-alt text-3xl text-blue-600 mb-2 block"></i>
                                        <p class="text-gray-700 font-medium">Klik untuk upload</p>
                                        <p class="text-gray-500 text-sm mt-1">JPG, PNG (Maks 5MB)</p>
                                    </div>
                                </label>
                                <?php if (!empty($pendaftar['pas_foto'])): ?>
                                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                        <img src="<?= htmlspecialchars(SITE_URL . ltrim($pendaftar['pas_foto'], '/')) ?>" alt="Pas Foto" class="h-32 rounded-lg shadow-md mx-auto">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 md:p-8 border-b border-gray-200">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <span>Data Pendidikan</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label block mb-2">Universitas</label>
                                <div class="autocomplete-container">
                                    <input type="text" id="universitasInput" name="universitas" placeholder="Ketik nama universitas..." class="autocomplete-input form-input" value="<?= htmlspecialchars($pendaftar['universitas'] ?? '') ?>" autocomplete="off">
                                    <div id="universitasList" class="autocomplete-list"></div>
                                </div>
                            </div>
                            <div>
                                <label class="form-label block mb-2">Jurusan</label>
                                <input type="text" name="jurusan" value="<?= htmlspecialchars($pendaftar['jurusan'] ?? '') ?>" placeholder="Teknik Informatika" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div>
                                <label class="form-label block mb-2">NIM</label>
                                <input type="text" name="nim" value="<?= htmlspecialchars($pendaftar['nim'] ?? '') ?>" placeholder="2021001234" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div>
                                <label class="form-label block mb-2">Semester</label>
                                <select name="semester" class="form-select w-full px-4 py-3 border rounded-lg bg-white">
                                    <option value="">-- Pilih --</option>
                                    <?php for($i=1; $i<=14; $i++): ?>
                                        <option value="<?= $i ?>" <?= ($pendaftar['semester'] ?? '') == $i ? 'selected' : '' ?>>Semester <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="form-label block mb-2">IPK (Opsional)</label>
                                <input type="text" name="ipk" value="<?= htmlspecialchars($pendaftar['ipk'] ?? '') ?>" placeholder="3.85" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                        </div>
                    </div>

                    <div class="p-6 md:p-8 border-b border-gray-200">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <span>Informasi Magang</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label block mb-2">Bidang / Divisi yang Diminati</label>
                                <div class="autocomplete-container">
                                    <input type="text" id="bidangInput" name="bidang_minat" placeholder="Ketik bidang yang diminati..." class="autocomplete-input form-input" value="<?= htmlspecialchars($pendaftar['bidang_minat'] ?? '') ?>" autocomplete="off">
                                    <div id="bidangList" class="autocomplete-list"></div>
                                </div>
                            </div>
                            <div>
                                <label class="form-label block mb-2">Durasi Magang</label>
                                <select name="durasi_magang" class="form-select w-full px-4 py-3 border rounded-lg bg-white">
                                    <option value="">-- Pilih --</option>
                                    <option value="1 bulan" <?= ($pendaftar['durasi_magang'] ?? '') == '1 bulan' ? 'selected' : '' ?>>1 Bulan</option>
                                    <option value="2 bulan" <?= ($pendaftar['durasi_magang'] ?? '') == '2 bulan' ? 'selected' : '' ?>>2 Bulan</option>
                                    <option value="3 bulan" <?= ($pendaftar['durasi_magang'] ?? '') == '3 bulan' ? 'selected' : '' ?>>3 Bulan</option>
                                    <option value="6 bulan" <?= ($pendaftar['durasi_magang'] ?? '') == '6 bulan' ? 'selected' : '' ?>>6 Bulan</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label block mb-2">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="<?= htmlspecialchars($pendaftar['tanggal_mulai'] ?? '') ?>" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div class="md:col-span-2">
                                <label class="form-label block mb-2">Alasan Magang</label>
                                <textarea name="alasan" rows="4" placeholder="Jelaskan motivasi Anda..." class="form-textarea w-full px-4 py-3 border rounded-lg resize-none"><?= htmlspecialchars($pendaftar['alasan'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 md:p-8 border-b border-gray-200">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-folder"></i>
                            </div>
                            <span>Dokumen Pendukung</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="form-label block mb-3">CV <span class="text-red-500">*</span></label>
                                <label class="file-upload-label">
                                    <input type="file" name="cv" accept=".pdf,.doc,.docx" class="hidden">
                                    <i class="fas fa-file-pdf text-2xl text-red-500 mb-2 block"></i>
                                    <p class="text-sm">Upload CV</p>
                                </label>
                            </div>
                            <div>
                                <label class="form-label block mb-3">Surat Pengantar <span class="text-red-500">*</span></label>
                                <label class="file-upload-label">
                                    <input type="file" name="surat" accept=".pdf" class="hidden">
                                    <i class="fas fa-file-contract text-2xl text-blue-500 mb-2 block"></i>
                                    <p class="text-sm">Upload Surat</p>
                                </label>
                            </div>
                            <div>
                                <label class="form-label block mb-3">KTM <span class="text-red-500">*</span></label>
                                <label class="file-upload-label">
                                    <input type="file" name="ktm" accept=".jpg,.jpeg,.png,.pdf" class="hidden">
                                    <i class="fas fa-id-card text-2xl text-green-500 mb-2 block"></i>
                                    <p class="text-sm">Upload KTM</p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 md:p-8 bg-gray-50 border-t border-gray-200 flex gap-4 justify-center">
                        <button type="reset" class="px-8 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-redo mr-2"></i> Bersihkan
                        </button>
                        <button type="submit" class="px-12 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg transition">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Data Universitas
        const universitasData = <?php 
            $data = [];
            foreach ($universitas_list as $tipe => $universitas) {
                foreach ($universitas as $univ) {
                    $data[] = [
                        'nama' => $univ['nama'],
                        'kota' => $univ['kota'],
                        'tipe' => $tipe,
                        'display' => $univ['nama'] . ' (' . $univ['kota'] . ')'
                    ];
                }
            }
            echo json_encode($data);
        ?>;

        // Data Bidang Minat
        const bidangData = <?php 
            $data = [];
            foreach ($bidang_minat_list as $divisi => $bidang) {
                foreach ($bidang as $item) {
                    $data[] = [
                        'nama' => $item['nama'],
                        'divisi' => $divisi,
                        'deskripsi' => $item['deskripsi']
                    ];
                }
            }
            echo json_encode($data);
        ?>;

        // Fungsi Autocomplete
        function setupAutocomplete(inputId, listId, dataSource) {
            const input = document.getElementById(inputId);
            const list = document.getElementById(listId);
            let selectedIndex = -1;

            input.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                
                if (query.length === 0) {
                    list.classList.remove('active');
                    selectedIndex = -1;
                    return;
                }

                const filtered = dataSource.filter(item => {
                    const searchText = (item.display || item.nama).toLowerCase();
                    return searchText.includes(query);
                });

                renderList(filtered, query);
                selectedIndex = -1;
            });

            function renderList(items, query) {
                if (items.length === 0) {
                    list.innerHTML = '<div class="no-results">Tidak ada hasil untuk pencarian</div>';
                    list.classList.add('active');
                    return;
                }

                // Kelompokkan berdasarkan kategori
                let grouped = {};
                items.forEach(item => {
                    const category = item.tipe || item.divisi || 'Lainnya';
                    if (!grouped[category]) grouped[category] = [];
                    grouped[category].push(item);
                });

                let html = '';
                for (const [category, items] of Object.entries(grouped)) {
                    html += `<div class="autocomplete-group">
                        <div class="autocomplete-group-title">${category}</div>`;
                    
                    items.forEach((item, idx) => {
                        const display = item.display || item.nama;
                        const highlighted = highlight(display, query);
                        html += `<div class="autocomplete-item" data-value="${display}">
                            ${highlighted}
                        </div>`;
                    });
                    
                    html += `</div>`;
                }

                list.innerHTML = html;
                list.classList.add('active');

                // Event listeners untuk items
                list.querySelectorAll('.autocomplete-item').forEach(item => {
                    item.addEventListener('click', function() {
                        input.value = this.getAttribute('data-value');
                        list.classList.remove('active');
                    });
                });
            }

            function highlight(text, query) {
                const regex = new RegExp(`(${query})`, 'gi');
                return text.replace(regex, '<span class="autocomplete-item-highlight">$1</span>');
            }

            // Close list when clicking outside
            document.addEventListener('click', function(e) {
                if (e.target !== input) {
                    list.classList.remove('active');
                }
            });

            input.addEventListener('focus', function() {
                if (this.value.length > 0) {
                    const event = new Event('input');
                    this.dispatchEvent(event);
                }
            });
        }

        // Initialize autocomplete
        setupAutocomplete('universitasInput', 'universitasList', universitasData);
        setupAutocomplete('bidangInput', 'bidangList', bidangData);

        // File upload handler
        document.querySelectorAll('.file-upload-label').forEach(label => {
            const input = label.querySelector('input[type="file"]');
            input.addEventListener('change', (e) => {
                if (input.files.length > 0) {
                    label.querySelector('p').textContent = `✓ ${input.files[0].name}`;
                    label.querySelector('p').classList.add('text-green-600');
                }
            });
            
            label.addEventListener('dragover', (e) => {
                e.preventDefault();
                label.style.backgroundColor = '#eff6ff';
                label.style.borderColor = '#3b82f6';
            });

            label.addEventListener('dragleave', () => {
                label.style.backgroundColor = '#f9fafb';
                label.style.borderColor = '#d1d5db';
            });

            label.addEventListener('drop', (e) => {
                e.preventDefault();
                label.style.backgroundColor = '#f9fafb';
                label.style.borderColor = '#d1d5db';
                input.files = e.dataTransfer.files;
                const event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            });
        });

        // Form submit handler
        document.getElementById('formPendaftar').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const alert = document.getElementById('alert');
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';

            try {
                const res = await fetch('<?= SITE_URL ?>api/upload', {
                    method: 'POST',
                    body: formData
                });
                const json = await res.json();
                alert.className = json.success ? 'mb-8 p-4 rounded-lg bg-green-500 text-white text-center shadow-md' : 'mb-8 p-4 rounded-lg bg-red-500 text-white text-center shadow-md';
                alert.innerHTML = `<i class="fas fa-${json.success ? 'check-circle' : 'exclamation-circle'} mr-2"></i> ${json.message}`;
                alert.classList.remove('hidden');
                if (json.success) setTimeout(() => location.reload(), 2000);
            } catch (err) {
                alert.className = 'mb-8 p-4 rounded-lg bg-red-500 text-white text-center shadow-md';
                alert.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i> Terjadi kesalahan';
                alert.classList.remove('hidden');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save mr-2"></i> Simpan';
            }
        });
    </script>
</body>
</html>