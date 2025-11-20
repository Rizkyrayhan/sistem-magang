<?php
// src/helpers/helper.php - VERSI FINAL ANTI REDECLARE

// GUARD: Jangan declare 2x
if (defined('HELPER_FUNCTIONS_LOADED')) {
    return;
}
define('HELPER_FUNCTIONS_LOADED', true);

// ============================================================================

function redirect($url) {
    header("Location: " . SITE_URL . $url);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['user']['role'] === 'admin';
}

function isPendaftar() {
    return isLoggedIn() && $_SESSION['user']['role'] === 'pendaftar';
}

function getCurrentUser() {
    return $_SESSION['user'] ?? null;
}

function getPendaftar($conn, $user_id) {
    if (!$conn || !$user_id) return null;
    
    $user_id = (int)$user_id;
    try {
        $stmt = $conn->prepare("SELECT * FROM pendaftar WHERE user_id = ? LIMIT 1");
        if (!$stmt) return null;
        
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) return null;
        
        $result = $stmt->get_result();
        if (!$result) return null;
        
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    } catch (Exception $e) {
        return null;
    }
}

function getEvaluasi($conn, $pendaftar_id) {
    if (!$conn || !$pendaftar_id) return null;
    
    $pendaftar_id = (int)$pendaftar_id;
    try {
        $stmt = $conn->prepare("SELECT * FROM evaluasi WHERE pendaftar_id = ? LIMIT 1");
        if (!$stmt) return null;
        
        $stmt->bind_param("i", $pendaftar_id);
        if (!$stmt->execute()) return null;
        
        $result = $stmt->get_result();
        if (!$result) return null;
        
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    } catch (Exception $e) {
        return null;
    }
}

function countPendaftar($conn, $status = null) {
    if (!$conn) return 0;
    
    try {
        if ($status) {
            $stmt = $conn->prepare("SELECT COUNT(*) as total FROM pendaftar WHERE status = ?");
            if (!$stmt) return 0;
            $stmt->bind_param("s", $status);
        } else {
            $stmt = $conn->prepare("SELECT COUNT(*) as total FROM pendaftar");
            if (!$stmt) return 0;
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return (int)$result['total'];
    } catch (Exception $e) {
        return 0;
    }
}

// Format tanggal
function formatTanggal($tanggal) {
    if (!$tanggal || $tanggal === '0000-00-00') return '-';
    return date('d/m/Y', strtotime($tanggal));
}

function formatTanggalFull($tanggal) {
    if (!$tanggal || $tanggal === '0000-00-00') return '-';
    $bulanIndo = [
        1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $hariIndo = [
        'Monday'=>'Senin', 'Tuesday'=>'Selasa', 'Wednesday'=>'Rabu',
        'Thursday'=>'Kamis', 'Friday'=>'Jumat', 'Saturday'=>'Sabtu', 'Sunday'=>'Minggu'
    ];
    try {
        $date = new DateTime($tanggal);
        return $hariIndo[$date->format('l')] . ', ' . $date->format('d') . ' ' . 
               $bulanIndo[(int)$date->format('m')] . ' ' . $date->format('Y');
    } catch (Exception $e) {
        return '-';
    }
}

// Badge status
function getBadgeStatus($status) {
    $badges = [
        'menunggu' => '<span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">Menunggu</span>',
        'diterima' => '<span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Diterima</span>',
        'ditolak'  => '<span class="px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-semibold">Ditolak</span>',
        'proses'   => '<span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">Sedang Magang</span>',
        'selesai'  => '<span class="px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">Selesai</span>'
    ];
    return $badges[$status] ?? '<span class="px-4 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-semibold">Unknown</span>';
}

// Asset URL untuk static files (CSS, JS, images)
function asset_url($path = '') {
    $path = ltrim($path, '/');
    return rtrim(SITE_URL, '/') . '/assets/' . $path;
}

/**
 * Generate URL yang aman untuk file yang diupload
 * Gunakan function ini untuk semua file di storage/uploads/
 */
function file_url($db_path) {
    if (!$db_path) {
        return SITE_URL . 'assets/placeholder.png';
    }
    
    // Path di database sudah berbentuk "storage/uploads/foto/xxx.jpg"
    return SITE_URL . 'view-file.php?file=' . urlencode($db_path);
}

// JSON Response untuk API
function json_response($success, $message, $data = null) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// ============================================================================
// END OF HELPER FUNCTIONS
?>