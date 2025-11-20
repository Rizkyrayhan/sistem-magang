<!-- views/admin/partials/sidebar.php -->
<div class="w-64 bg-blue-800 text-white flex flex-col shadow-xl">
    <div class="p-6 text-center border-b border-blue-700">
        <img src="<?= asset_url('../src/images/logo_lemigas.png') ?>" alt="LEMIGAS" class="h-16 mx-auto mb-3">
        <h1 class="font-bold text-xl">Sistem Magang</h1>
        <p class="text-sm opacity-90">Admin Dashboard</p>
    </div>
    <nav class="flex-1 p-4 space-y-2">
        <a href="<?= SITE_URL ?>admin/dashboard" class="flex items-center space-x-3 px-4 py-3 <?= ($current=='dashboard'?'bg-blue-900':'hover:bg-blue-700') ?> rounded-lg transition">
            <i class="fas fa-home"></i> <span>Dashboard</span>
        </a>
        <a href="<?= SITE_URL ?>admin/data-pendaftar" class="flex items-center space-x-3 px-4 py-3 <?= ($current=='data-pendaftar'?'bg-blue-900':'hover:bg-blue-700') ?> rounded-lg transition">
            <i class="fas fa-users"></i> <span>Data Pendaftar</span>
        </a>
        <a href="<?= SITE_URL ?>admin/evaluasi" class="flex items-center space-x-3 px-4 py-3 <?= ($current=='evaluasi'?'bg-blue-900':'hover:bg-blue-700') ?> rounded-lg transition">
            <i class="fas fa-clipboard-check"></i> <span>Evaluasi</span>
        </a>
        <a href="<?= SITE_URL ?>admin/laporan" class="flex items-center space-x-3 px-4 py-3 <?= ($current=='laporan'?'bg-blue-900':'hover:bg-blue-700') ?> rounded-lg transition">
            <i class="fas fa-chart-bar"></i> <span>Laporan</span>
        </a>
    </nav>
    <div class="p-6 border-t border-blue-700">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center font-bold">
                <?= strtoupper(substr(getCurrentUser()['nama']??'A', 0, 1)) ?>
            </div>
            <div>
                <p class="font-medium"><?= getCurrentUser()['nama']??'Admin' ?></p>
                <p class="text-xs opacity-75">Administrator</p>
            </div>
        </div>
        <a href="<?= SITE_URL ?>logout" class="block text-center bg-red-600 hover:bg-red-700 py-2 rounded-lg text-sm">
            <i class="fas fa-sign-out-alt mr-1"></i> Logout
        </a>
    </div>
</div>