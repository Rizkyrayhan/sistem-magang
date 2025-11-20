<?php
// Lokasi: views/user/status-pendaftaran.php
// ⚠️ PENTING: Load config DULU sebelum apapun!

// 1. Load config (ini include helper otomatis)
require_once __DIR__ . '/../../config.php';

// 2. Load helper (redundant tapi aman)
require_once __DIR__ . '/../../src/helpers/helper.php';

// 3. Security check
if (!isLoggedIn() || !isPendaftar()) {
    redirect('login');
}

// 4. Get data user
$user = getCurrentUser();
$pendaftar = getPendaftar($conn, $user['id']) ?: [];
$current = 'status';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Data Diri - LEMIGAS Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .main-content { margin-left: 18rem; width: calc(100% - 18rem); }
        @media (max-width: 1024px) { .main-content { margin-left: 0; width: 100%; } }
        
        .form-section { border-left: 4px solid rgb(37, 99, 235); }
        .form-label { font-weight: 600; color: rgb(31, 41, 55); font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-input, .form-select, .form-textarea { font-size: 0.95rem; border: 1px solid rgb(209, 213, 219); transition: all 0.3s ease; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: rgb(37, 99, 235); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); outline: none; }
        .section-title { display: flex; align-items: center; gap: 0.75rem; font-size: 1.25rem; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid rgb(229, 231, 235); }
        .section-icon { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: rgb(37, 99, 235); color: white; border-radius: 8px; font-size: 1rem; }
        .file-upload-label { display: inline-block; padding: 2.5rem; border: 2px dashed rgb(209, 213, 219); border-radius: 0.75rem; background-color: rgb(249, 250, 251); cursor: pointer; transition: all 0.3s ease; width: 100%; text-align: center; }
        .file-upload-label:hover { border-color: rgb(37, 99, 235); background-color: rgb(239, 246, 255); }
        .preview-container { margin-top: 1rem; padding: 1rem; background-color: rgb(249, 250, 251); border: 1px solid rgb(229, 231, 235); border-radius: 0.75rem; text-align: center; }
        .preview-img { max-height: 180px; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .progress-step { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background-color: rgb(226, 232, 240); border-radius: 9999px; font-size: 0.875rem; font-weight: 500; color: rgb(51, 65, 85); }
        .progress-step.active { background-color: rgb(37, 99, 235); color: white; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar - HANYA INCLUDE, JANGAN REQUIRE -->
        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content flex-1 overflow-y-auto">
            <!-- Header Premium -->
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-900 text-white py-10 px-8 shadow-lg">
                <div class="max-w-7xl mx-auto">
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-alt text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-blue-100 text-sm font-medium">FORMULIR PENDAFTARAN</p>
                                    <h1 class="text-3xl font-bold">Data Diri & Dokumen Pendukung</h1>
                                </div>
                            </div>
                            <p class="text-blue-200 text-sm ml-0">Lengkapi informasi pribadi, pendidikan, dan dokumen yang diperlukan</p>
                        </div>
                    </div>
                    <div class="flex gap-2 flex-wrap mt-6">
                        <span class="progress-step active"><i class="fas fa-circle-1"></i> Data Pribadi</span>
                        <span class="progress-step"><i class="fas fa-circle-2"></i> Pendidikan</span>
                        <span class="progress-step"><i class="fas fa-circle-3"></i> Magang</span>
                        <span class="progress-step"><i class="fas fa-circle-4"></i> Dokumen</span>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="max-w-7xl mx-auto px-8 py-8">
                <!-- Alert Message -->
                <div id="alert" class="hidden mb-8 p-4 rounded-lg text-white font-medium text-center shadow-md"></div>

                <!-- Form Container -->
                <form id="formPendaftar" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md overflow-hidden">
                    
                    <!-- Section 1: Data Pribadi -->
                    <div class="p-8 border-b border-gray-200">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>1. DATA PRIBADI</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap & Email -->
                            <div>
                                <label class="form-label block mb-2">Nama Lengkap</label>
                                <input type="text" value="<?= htmlspecialchars($user['nama']) ?>" disabled class="form-input w-full px-4 py-3 border rounded-lg bg-gray-50 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="form-label block mb-2">Email</label>
                                <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled class="form-input w-full px-4 py-3 border rounded-lg bg-gray-50 cursor-not-allowed">
                            </div>

                            <!-- Tempat & Tanggal Lahir -->
                            <div>
                                <label class="form-label block mb-2">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($pendaftar['tempat_lahir'] ?? '') ?>" placeholder="Cth: Jakarta" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div>
                                <label class="form-label block mb-2">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($pendaftar['tanggal_lahir'] ?? '') ?>" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>

                            <!-- Jenis Kelamin & No HP -->
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
                                <input type="text" name="no_hp" value="<?= htmlspecialchars($pendaftar['no_hp'] ?? '') ?>" placeholder="Cth: 08123456789" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>

                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <label class="form-label block mb-2">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" placeholder="Jl. Raya No. 123, Kel. Margo, Kec. Menteng, Jakarta Pusat 10350" class="form-textarea w-full px-4 py-3 border rounded-lg resize-none"><?= htmlspecialchars($pendaftar['alamat'] ?? '') ?></textarea>
                            </div>

                            <!-- Pas Foto -->
                            <div class="md:col-span-2">
                                <label class="form-label block mb-3">Pas Foto 3x4 <span class="text-red-500">*</span> <span class="text-gray-500 text-xs font-normal">(Background Merah, JPG/PNG, Maks 5MB)</span></label>
                                <label class="file-upload-label cursor-pointer">
                                    <input type="file" name="foto" accept=".jpg,.jpeg,.png" class="hidden" id="fotoInput">
                                    <div>
                                        <i class="fas fa-cloud-upload-alt text-3xl text-blue-600 mb-2 block"></i>
                                        <p class="text-gray-700 font-medium">Klik untuk upload atau drag & drop</p>
                                        <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG (Maks 5MB)</p>
                                    </div>
                                </label>

                                <?php if (!empty($pendaftar['pas_foto'])): ?>
                                    <div class="preview-container">
                                        <p class="text-gray-700 text-sm font-medium mb-3">📸 Foto Profil Saat Ini</p>
                                        <img src="<?= htmlspecialchars(SITE_URL . ltrim($pendaftar['pas_foto'], '/')) ?>" alt="Pas Foto" class="preview-img mx-auto" onerror="this.style.display='none'">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Data Pendidikan -->
                    <div class="p-8 border-b border-gray-200">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <span>2. DATA PENDIDIKAN</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label block mb-2">Universitas / Kampus</label>
                                <input type="text" name="universitas" value="<?= htmlspecialchars($pendaftar['universitas'] ?? '') ?>" placeholder="Cth: Universitas Indonesia" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div>
                                <label class="form-label block mb-2">Program Studi / Jurusan</label>
                                <input type="text" name="jurusan" value="<?= htmlspecialchars($pendaftar['jurusan'] ?? '') ?>" placeholder="Cth: Teknik Informatika" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div>
                                <label class="form-label block mb-2">NIM (Nomor Induk Mahasiswa)</label>
                                <input type="text" name="nim" value="<?= htmlspecialchars($pendaftar['nim'] ?? '') ?>" placeholder="Cth: 2021001234" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div>
                                <label class="form-label block mb-2">Semester Saat Ini</label>
                                <select name="semester" class="form-select w-full px-4 py-3 border rounded-lg bg-white">
                                    <option value="">-- Pilih --</option>
                                    <?php for($i=1; $i<=14; $i++): ?>
                                        <option value="<?= $i ?>" <?= ($pendaftar['semester'] ?? '') == $i ? 'selected' : '' ?>>Semester <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="form-label block mb-2">IPK (Opsional)</label>
                                <input type="text" name="ipk" value="<?= htmlspecialchars($pendaftar['ipk'] ?? '') ?>" placeholder="Cth: 3.85" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Informasi Magang -->
                    <div class="p-8 border-b border-gray-200">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <span>3. INFORMASI MAGANG</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label block mb-2">Bidang / Divisi yang Diminati</label>
                                <input type="text" name="bidang_minat" value="<?= htmlspecialchars($pendaftar['bidang_minat'] ?? '') ?>" placeholder="Cth: Oil & Gas, IT, HSE, Laboratorium" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div>
                                <label class="form-label block mb-2">Durasi Magang</label>
                                <select name="durasi_magang" class="form-select w-full px-4 py-3 border rounded-lg bg-white">
                                    <option value="">-- Pilih Durasi --</option>
                                    <option value="1 bulan" <?= ($pendaftar['durasi_magang'] ?? '') == '1 bulan' ? 'selected' : '' ?>>1 Bulan</option>
                                    <option value="2 bulan" <?= ($pendaftar['durasi_magang'] ?? '') == '2 bulan' ? 'selected' : '' ?>>2 Bulan</option>
                                    <option value="3 bulan" <?= ($pendaftar['durasi_magang'] ?? '') == '3 bulan' ? 'selected' : '' ?>>3 Bulan</option>
                                    <option value="6 bulan" <?= ($pendaftar['durasi_magang'] ?? '') == '6 bulan' ? 'selected' : '' ?>>6 Bulan</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label block mb-2">Tanggal Mulai Magang</label>
                                <input type="date" name="tanggal_mulai" value="<?= htmlspecialchars($pendaftar['tanggal_mulai'] ?? '') ?>" class="form-input w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div class="md:col-span-2">
                                <label class="form-label block mb-2">Alasan Ingin Magang di LEMIGAS</label>
                                <textarea name="alasan" rows="4" placeholder="Jelaskan motivasi dan alasan Anda memilih LEMIGAS untuk melaksanakan magang..." class="form-textarea w-full px-4 py-3 border rounded-lg resize-none"><?= htmlspecialchars($pendaftar['alasan'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Dokumen Pendukung -->
                    <div class="p-8 border-b border-gray-200">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <span>4. DOKUMEN PENDUKUNG</span>
                        </div>

                        <p class="text-gray-600 text-sm mb-6">Upload dokumen dalam format PDF, JPG, PNG atau DOC (Maks 5MB per file)</p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="form-label block mb-3">CV / Resume <span class="text-red-500">*</span></label>
                                <label class="file-upload-label">
                                    <input type="file" name="cv" accept=".pdf,.doc,.docx" class="hidden">
                                    <div>
                                        <i class="fas fa-file-pdf text-2xl text-red-500 mb-2 block"></i>
                                        <p class="text-gray-700 font-medium text-sm">Upload CV</p>
                                        <p class="text-gray-500 text-xs mt-1">PDF, DOC, DOCX</p>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="form-label block mb-3">Surat Pengantar Kampus <span class="text-red-500">*</span></label>
                                <label class="file-upload-label">
                                    <input type="file" name="surat" accept=".pdf" class="hidden">
                                    <div>
                                        <i class="fas fa-file-contract text-2xl text-blue-500 mb-2 block"></i>
                                        <p class="text-gray-700 font-medium text-sm">Upload Surat</p>
                                        <p class="text-gray-500 text-xs mt-1">PDF Only</p>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="form-label block mb-3">KTM / Kartu Mahasiswa <span class="text-red-500">*</span></label>
                                <label class="file-upload-label">
                                    <input type="file" name="ktm" accept=".jpg,.jpeg,.png,.pdf" class="hidden">
                                    <div>
                                        <i class="fas fa-id-card text-2xl text-green-500 mb-2 block"></i>
                                        <p class="text-gray-700 font-medium text-sm">Upload KTM</p>
                                        <p class="text-gray-500 text-xs mt-1">JPG, PNG, PDF</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button Section -->
                    <div class="p-8 bg-gray-50 border-t border-gray-200">
                        <div class="flex gap-4 justify-center">
                            <button type="reset" class="px-8 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition">
                                <i class="fas fa-redo mr-2"></i> Bersihkan
                            </button>
                            <button type="submit" class="px-12 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-lg shadow-lg transition transform hover:shadow-xl">
                                <i class="fas fa-save mr-2"></i> SIMPAN DATA & DOKUMEN
                            </button>
                        </div>
                        <p class="text-center text-gray-500 text-xs mt-4">Data Anda akan disimpan secara aman di server LEMIGAS</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.file-upload-label').forEach(label => {
            const input = label.querySelector('input[type="file"]');
            
            label.addEventListener('click', (e) => {
                input.click();
            });

            input.addEventListener('change', (e) => {
                if (input.files.length > 0) {
                    const fileName = input.files[0].name;
                    const fileSize = (input.files[0].size / (1024 * 1024)).toFixed(2);
                    const text = label.querySelector('p:first-of-type');
                    text.textContent = `✓ ${fileName} (${fileSize}MB)`;
                    text.classList.add('text-green-600');
                }
            });

            label.addEventListener('dragover', (e) => {
                e.preventDefault();
                label.style.backgroundColor = 'rgb(239, 246, 255)';
                label.style.borderColor = 'rgb(37, 99, 235)';
            });

            label.addEventListener('dragleave', () => {
                label.style.backgroundColor = 'rgb(249, 250, 251)';
                label.style.borderColor = 'rgb(209, 213, 219)';
            });

            label.addEventListener('drop', (e) => {
                e.preventDefault();
                label.style.backgroundColor = 'rgb(249, 250, 251)';
                label.style.borderColor = 'rgb(209, 213, 219)';
                input.files = e.dataTransfer.files;
                const event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            });
        });

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

                alert.className = json.success 
                    ? 'mb-8 p-4 rounded-lg bg-green-500 text-white text-center shadow-md' 
                    : 'mb-8 p-4 rounded-lg bg-red-500 text-white text-center shadow-md';
                alert.innerHTML = `<i class="fas fa-${json.success ? 'check-circle' : 'exclamation-circle'} mr-2"></i> ${json.message}`;
                alert.classList.remove('hidden');

                if (json.success) {
                    setTimeout(() => location.reload(), 2000);
                }
            } catch (err) {
                alert.className = 'mb-8 p-4 rounded-lg bg-red-500 text-white text-center shadow-md';
                alert.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i> Terjadi kesalahan jaringan. Silakan coba lagi.';
                alert.classList.remove('hidden');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save mr-2"></i> SIMPAN DATA & DOKUMEN';
            }
        });
    </script>
</body>
</html>