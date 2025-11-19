<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/helpers/helper.php';

// ==================================================================
// PARSE URL - BERSIH TANPA .htaccess
// ==================================================================
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];
$base_path   = dirname($script_name);
$base_path   = ($base_path === '/' || $base_path === '\\') ? '' : rtrim($base_path, '/');

if ($base_path && strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}

$path = parse_url($request_uri, PHP_URL_PATH);
$route = trim($path, '/');
$route = preg_replace('#^index\.php/?#i', '', $route);
$route = $route ?: 'landing';

// Auto define SITE_URL
if (!defined('SITE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    define('SITE_URL', $protocol . $_SERVER['HTTP_HOST'] . $base_path . '/');
}

// ==================================================================
// LOGOUT LANGSUNG DI SINI (pasti jalan)
// ==================================================================
if ($route === 'logout') {
    session_destroy();
    header('Location: ' . SITE_URL . 'login');
    exit;
}

// ==================================================================
// DAFTAR ROUTES (semua file view & controller)
// ==================================================================
$routes = [
    ''                          => 'views/landing.php',
    'landing'                   => 'views/landing.php',

    'login'                     => 'views/auth/login.php',
    'register'                  => 'views/auth/register.php',

    // Admin Routes
    'admin'                     => 'views/admin/dashboard.php',
    'admin/dashboard'                   => 'views/admin/dashboard.php',
    'admin/dashboard'           => 'views/admin/dashboard.php',
    'admin/data-pendaftar'      => 'views/admin/data-pendaftar.php',
    'admin/evaluasi'            => 'views/admin/evaluasi.php',
    'admin/laporan'             => 'views/admin/laporan.php',

    // User Routes
    'user'                      => 'views/user/dashboard.php',
    'user/'                     => 'views/user/dashboard.php',
    'user/dashboard'            => 'views/user/dashboard.php',
    'user/status-pendaftaran'   => 'views/user/status-pendaftaran.php',
    'user/hasil-evaluasi'       => 'views/user/hasil-evaluasi.php',

    // API
    'api/login'                 => 'src/controllers/AuthController.php',
    'api/register'              => 'src/controllers/AuthController.php',
    'api/get-pendaftar'         => 'src/controllers/DaftarController.php',
    'api/tambah-pendaftar'      => 'src/controllers/DaftarController.php',
    'api/simpan-evaluasi'       => 'src/controllers/EvaluasiController.php',

    'generate-password'         => 'generate-password.php',
];

// ==================================================================
// PROTEKSI ROUTE - DULUAN SEBELUM LOAD FILE!
// ==================================================================
$needLogin = preg_match('#^(admin|user(/.*)?)$#i', $route);

if ($needLogin) {
    if (!isLoggedIn()) {
        redirect('login');
        exit;
    }

    if (strpos($route, 'admin') === 0 && !isAdmin()) {
        redirect('login');
        exit;
    }

    if (strpos($route, 'user') === 0 && !isPendaftar()) {
        redirect('login');
        exit;
    }
}

// ==================================================================
// SET ACTION UNTUK API
// ==================================================================
if (strpos($route, 'api/') === 0) {
    $actionMap = [
        'api/login'            => 'login',
        'api/register'         => 'register',
        'api/get-pendaftar'    => 'getPendaftar',
        'api/tambah-pendaftar' => 'tambah',
        'api/simpan-evaluasi'  => 'simpan',
    ];
    $_GET['action'] = $actionMap[$route] ?? '';
}

// ==================================================================
// LOAD FILE VIEW / CONTROLLER
// ==================================================================
if (isset($routes[$route])) {
    $file = $routes[$route];
    if (file_exists($file)) {
        require_once $file;
        exit;
    }
}

// ==================================================================
// 404 - Jika route tidak ada
// ==================================================================
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found - LEMIGAS Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-8xl font-bold text-gray-800">404</h1>
        <p class="text-2xl text-gray-600 mt-4">Halaman Tidak Ditemukan</p>
        <p class="text-gray-500">Route: <code><?php echo htmlspecialchars($route); ?></code></p>
        <a href="<?php echo SITE_URL; ?>" class="mt-8 inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
<?php exit; ?>