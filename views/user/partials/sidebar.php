<?php
$user = getCurrentUser();
if (!$user || empty($user['id'])) {
    return;
}

$pendaftar = getPendaftar($conn, $user['id']);
$pas_foto_url = '';
if ($pendaftar && !empty($pendaftar['pas_foto'])) {
    $pas_foto_url = file_url($pendaftar['pas_foto']);
}

$initials = strtoupper(substr($user['nama'] ?? 'U', 0, 1));
?>

<style>
    /*
     * PERUBAHAN UTAMA: Menerapkan position: fixed untuk tampilan desktop (>= 1025px)
     * sehingga sidebar tetap di tempat saat halaman digulir.
     */
    .sidebar {
        position: fixed; /* Membuat sidebar tetap di viewport */
        left: 0;
        top: 0;
        height: 100vh; /* Mengambil tinggi penuh viewport */
        z-index: 20; /* Pastikan di atas konten utama */
        width: 280px;
        /* Hapus overflow-y-auto dari class HTML, pindah ke sini jika ingin kontrol scrollbar */
        transition: transform 0.3s ease, visibility 0.3s ease;
    }

    @media (max-width: 1024px) {
        .sidebar {
            /* Properti fixed dan dimensi sudah diatur di atas */
            z-index: 40; /* Lebih tinggi untuk menindih overlay */
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
            visibility: visible;
        }
    }

    .sidebar-overlay {
        display: none;
    }

    @media (max-width: 1024px) {
        .sidebar-overlay {
            display: block;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 30;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }
    }

    .toggle-sidebar {
        display: none;
    }

    @media (max-width: 1024px) {
        .toggle-sidebar {
            display: flex;
        }
    }
</style>

<div class="sidebar bg-white shadow-lg flex flex-col border-r border-gray-200 overflow-y-auto">
    <div class="p-6 text-center border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
        <div class="relative inline-block mx-auto mb-4">
            <div id="foto-fallback" 
                 class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 
                        flex items-center justify-center text-white text-3xl font-bold shadow-lg
                        transition-opacity duration-300">
                <?= $initials ?>
            </div>

            <?php if ($pas_foto_url): ?>
                <img 
                    src="<?= htmlspecialchars($pas_foto_url) ?>" 
                    alt="Foto Profil <?= htmlspecialchars($user['nama']) ?>"
                    class="absolute inset-0 w-24 h-24 rounded-full object-cover 
                            border-4 border-white shadow-lg 
                            opacity-0 transition-opacity duration-500"
                    onload="this.classList.add('opacity-100'); 
                            this.previousElementSibling.classList.add('opacity-0', 'pointer-events-none');"
                    onerror="this.classList.remove('opacity-100'); 
                            this.classList.add('hidden');">
            <?php endif; ?>

            <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 rounded-full border-2 border-white shadow-md"></div>
        </div>

        <h2 class="text-lg font-bold text-gray-800 mt-3">
            <?= htmlspecialchars(substr($user['nama'], 0, 20)) ?>
        </h2>
        <p class="text-xs text-blue-600 font-semibold mt-1">Peserta Magang</p>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="<?= SITE_URL ?>user/dashboard" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                  <?= ($current ?? '') === 'dashboard' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' ?>">
            <i class="fas fa-chart-line text-lg"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="<?= SITE_URL ?>user/status-pendaftaran" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                  <?= ($current ?? '') === 'status' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' ?>">
            <i class="fas fa-file-invoice text-lg"></i>
            <span class="font-medium">Data Diri</span>
        </a>

        <a href="<?= SITE_URL ?>user/hasil-evaluasi" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                  <?= ($current ?? '') === 'evaluasi' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100' ?>">
            <i class="fas fa-star text-lg"></i>
            <span class="font-medium">Evaluasi</span>
        </a>
    </nav>

    <div class="p-4 border-t border-gray-200 bg-gray-50">
        <a href="<?= SITE_URL ?>logout" 
           class="flex items-center justify-center space-x-2 bg-red-50 hover:bg-red-100 text-red-600 
                  px-4 py-3 rounded-lg transition font-semibold w-full">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </div>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.querySelector('.toggle-sidebar');

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    // Toggle dari button
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }

    // Close sidebar saat klik overlay
    if (overlay) {
        overlay.addEventListener('click', toggleSidebar);
    }

    // Close sidebar saat klik link
    sidebar.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 1024) {
                toggleSidebar();
            }
        });
    });
</script>