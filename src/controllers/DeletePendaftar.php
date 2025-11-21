<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/helpers/helper.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    exit;
}

if (!isAdmin()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
    exit;
}

// Hapus data pendaftar
$delete = $conn->query("DELETE FROM pendaftar WHERE id = $id");

if ($delete) {
    echo json_encode(['success' => true, 'message' => '✅ Pendaftar berhasil dihapus']);
} else {
    echo json_encode(['success' => false, 'message' => '❌ Gagal menghapus pendaftar']);
}
?>