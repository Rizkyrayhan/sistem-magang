<!-- views/admin/partials/sidebar.php -->
<div id="sidebar" class="fixed inset-y-0 left-0 z-40 w-72 bg-white border-r border-gray-200 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto shadow-lg md:shadow-none md:relative md:z-auto">
    <div class="flex flex-col h-full">
        <!-- Logo Section -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                    <img src="<?= SITE_URL ?>src/images/logo_lemigas.png" alt="Logo" class="w-8 h-8">
                <div>
                    <h1 class="font-bold text-gray-900 text-base">Sistem Magang</h1>
                    <p class="text-xs text-gray-500">Admin Dashboard</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-4 space-y-1">
            <a href="<?= SITE_URL ?>admin/dashboard" class="flex items-center space-x-3 px-4 py-3 <?= ($current=='dashboard'?'bg-blue-50 text-blue-600 font-medium':'text-gray-700 hover:bg-gray-100') ?> rounded-lg transition">
                <i class="fas fa-home w-5 text-center"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="<?= SITE_URL ?>admin/data-pendaftar" class="flex items-center space-x-3 px-4 py-3 <?= ($current=='data-pendaftar'?'bg-blue-50 text-blue-600 font-medium':'text-gray-700 hover:bg-gray-100') ?> rounded-lg transition">
                <i class="fas fa-users w-5 text-center"></i>
                <span>Data Pendaftar</span>
            </a>
            
            <a href="<?= SITE_URL ?>admin/evaluasi" class="flex items-center space-x-3 px-4 py-3 <?= ($current=='evaluasi'?'bg-blue-50 text-blue-600 font-medium':'text-gray-700 hover:bg-gray-100') ?> rounded-lg transition">
                <i class="fas fa-clipboard-check w-5 text-center"></i>
                <span>Evaluasi</span>
            </a>
            
            <a href="<?= SITE_URL ?>admin/laporan" class="flex items-center space-x-3 px-4 py-3 <?= ($current=='laporan'?'bg-blue-50 text-blue-600 font-medium':'text-gray-700 hover:bg-gray-100') ?> rounded-lg transition">
                <i class="fas fa-chart-bar w-5 text-center"></i>
                <span>Laporan</span>
            </a>
        </nav>

        <!-- User Profile Section -->
        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition cursor-pointer mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center font-bold text-white flex-shrink-0 text-sm">
                    <?= strtoupper(substr(getCurrentUser()['nama']??'A', 0, 1)) ?>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="font-medium text-gray-900 text-sm truncate"><?= htmlspecialchars(getCurrentUser()['nama']??'Admin') ?></p>
                    <p class="text-xs text-gray-500 truncate">Administrator</p>
                </div>
            </div>
            
            <a href="<?= SITE_URL ?>logout" class="flex items-center justify-center space-x-2 w-full bg-red-50 text-red-600 hover:bg-red-100 py-2 px-4 rounded-lg text-sm font-medium transition">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>

<!-- Overlay untuk Mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden hidden transition-opacity duration-300"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarToggleButtons = document.querySelectorAll('#sidebarToggle');

        // Toggle Sidebar dari semua button dengan id sidebarToggle
        sidebarToggleButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Toggle clicked');
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            });
        });

        // Close sidebar when overlay is clicked
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            });
        }

        // Close sidebar when a link is clicked (mobile only)
        document.querySelectorAll('#sidebar nav a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }
        });
    });
</script>