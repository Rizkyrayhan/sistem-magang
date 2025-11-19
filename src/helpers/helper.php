<?php

function redirect($url) {
    header("Location: " . SITE_URL . $url);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function isPendaftar() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'pendaftar';
}

function getCurrentUser() {
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

function getUser($conn, $id) {
    $id = (int)$id;
    $result = $conn->query("SELECT * FROM users WHERE id = $id LIMIT 1");
    return $result ? $result->fetch_assoc() : null;
}

function getPendaftar($conn, $user_id) {
    $user_id = (int)$user_id;
    $result = $conn->query("SELECT * FROM pendaftar WHERE user_id = $user_id LIMIT 1");
    return $result ? $result->fetch_assoc() : null;
}

function getAllPendaftar($conn) {
    $result = $conn->query("SELECT p.*, u.nama, u.email FROM pendaftar p JOIN users u ON p.user_id = u.id ORDER BY p.tanggal_daftar DESC");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : array();
}

function getEvaluasi($conn, $pendaftar_id) {
    $pendaftar_id = (int)$pendaftar_id;
    $result = $conn->query("SELECT * FROM evaluasi WHERE pendaftar_id = $pendaftar_id LIMIT 1");
    return $result ? $result->fetch_assoc() : null;
}

function countPendaftar($conn, $status = null) {
    if ($status) {
        $status = $conn->real_escape_string($status);
        $result = $conn->query("SELECT COUNT(*) as count FROM pendaftar WHERE status = '$status'");
    } else {
        $result = $conn->query("SELECT COUNT(*) as count FROM pendaftar");
    }
    $row = $result->fetch_assoc();
    return (int)$row['count'];
}

function formatTanggal($tanggal) {
    if (!$tanggal) return '-';
    $date = new DateTime($tanggal);
    return $date->format('d/m/Y');
}

function formatTanggalFull($tanggal) {
    if (!$tanggal) return '-';
    $date = new DateTime($tanggal);
    return $date->format('l, d F Y');
}

function getBadgeStatus($status) {
    $badges = array(
        'menunggu' => '<span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Menunggu</span>',
        'diterima' => '<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Diterima</span>',
        'ditolak' => '<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Ditolak</span>',
        'proses' => '<span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">Proses</span>',
        'selesai' => '<span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">Selesai</span>'
    );
    return isset($badges[$status]) ? $badges[$status] : '<span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">-</span>';
}

function json_response($success, $message, $data = null) {
    header('Content-Type: application/json');
    echo json_encode(array(
        'success' => $success,
        'message' => $message,
        'data' => $data
    ));
    exit;
}

?>