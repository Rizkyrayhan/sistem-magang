<!-- views/user/partials/sidebar.php -->
<?php
// ⚠️ CONFIG & HELPER SUDAH DI-LOAD DI FILE PARENT
$user = getCurrentUser();
if (!$user || empty($user['id'])) {
    return;
}

// Ambil data pendaftar
$pendaftar = getPendaftar($conn, $user['id']);

// URL foto pakai view-file.php supaya aman & pasti muncul
$pas_foto_url = '';
if ($pendaftar && !empty($pendaftar['pas_foto'])) {
    // Pastikan pakai helper file_url() biar lewat view-file.php
    $pas_foto_url = file_url($pendaftar['pas_foto']);
}

$initials = strtoupper(substr($user['nama'] ?? 'U', 0, 1));
?>

<div class="fixed inset-y-0 left-0 w-72 bg-white shadow-xl flex flex-col border-r border-gray-200 z-50 overflow-y-auto">
    <!-- Header Profil -->
    <div class="p-8 text-center border-b border-gray-200">
        <div class="relative inline-block mx-auto">
            <!-- Fallback: Inisial (selalu tampil dulu) -->
            <div id="foto-fallback" 
                 class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 
                        flex items-center justify-center text-white text-5xl font-bold shadow-xl
                        transition-opacity duration-300">
                <?= $initials ?>
            </div>

            <!-- Foto Asli (absolute, awalnya hidden) -->
            <?php if ($pas_foto_url): ?>
                <img 
                    src="<?= htmlspecialchars($pas_foto_url) ?>" 
                    alt="Foto Profil <?= htmlspecialchars($user['nama']) ?>"
                    class="absolute inset-0 w-32 h-32 rounded-full object-cover 
                           border-4 border-blue-600 shadow-xl 
                           opacity-0 transition-opacity duration-500"
                    onload="this.classList.add('opacity-100'); 
                            this.previousElementSibling.classList.add('opacity-0', 'pointer-events-none');"
                    onerror="this.classList.remove('opacity-100'); 
                             this.classList.add('hidden');">
            <?php endif; ?>

            <!-- Status Online (pojok kanan bawah) -->
            <div class="absolute bottom-0 right-0 w-9 h-9 bg-green-500 rounded-full border-4 border-white shadow-md"></div>
        </div>

        <!-- Nama & Jabatan -->
        <h2 class="mt-6 text-2xl font-bold text-gray-800">
            <?= htmlspecialchars($user['nama'] ?? 'User') ?>
        </h2>
        <p class="text-sm text-blue-600 font-semibold">Peserta Magang</p>
        <p class="text-xs text-gray-500 mt-1">LEMIGAS - Kementerian ESDM</p>
    </div>

    <!-- Navigasi -->
    <nav class="flex-1 px-6 py-8 space-y-3">
        <a href="<?= SITE_URL ?>user/dashboard" 
           class="group flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-200 
                  <?= ($current ?? '') === 'dashboard' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-700 hover:bg-blue-50 hover:shadow-md' ?>">
            <div class="flex items-center space-x-4">
                <i class="fas fa-home text-xl"></i>
                <span class="font-semibold">Dashboard</span>
            </div>
            <?= ($current ?? '') === 'dashboard' ? '<i class="fas fa-chevron-right"></i>' : '' ?>
        </a>

        <a href="<?= SITE_URL ?>user/status-pendaftaran" 
           class="group flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-200 
                  <?= ($current ?? '') === 'status' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-700 hover:bg-blue-50 hover:shadow-md' ?>">
            <div class="flex items-center space-x-4">
                <i class="fas fa-file-alt text-xl"></i>
                <span class="font-semibold">Data Diri & Dokumen</span>
            </div>
            <?= ($current ?? '') === 'status' ? '<i class="fas fa-chevron-right"></i>' : '' ?>
        </a>

        <a href="<?= SITE_URL ?>user/hasil-evaluasi" 
           class="group flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-200 
                  <?= ($current ?? '') === 'evaluasi' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-700 hover:bg-blue-50 hover:shadow-md' ?>">
            <div class="flex items-center space-x-4">
                <i class="fas fa-trophy text-xl"></i>
                <span class="font-semibold">Hasil Evaluasi</span>
            </div>
            <?= ($current ?? '') === 'evaluasi' ? '<i class="fas fa-chevron-right"></i>' : '' ?>
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-6 border-t border-gray-200">
        <a href="<?= SITE_URL ?>logout" 
           class="flex items-center justify-center space-x-3 bg-red-50 hover:bg-red-100 text-red-600 
                  px-8 py-4 rounded-2xl transition font-semibold text-lg shadow-md">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </div>
</div>

<!-- Responsive -->
<style>
    .main-content {
        margin-left: 18rem;
        width: calc(100% - 18rem);
        transition: all 0.3s ease;
    }
    @media (max-width: 1024px) {
        .main-content {
            margin-left: 0;
            width: 100%;
        }
        .fixed {
            position: relative !important;
        }
    }
</style>