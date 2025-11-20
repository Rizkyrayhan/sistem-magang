<?php
// src/controllers/SetStatusController.php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/helpers/helper.php';

if (!isLoggedIn() || !isAdmin()) {
    json_response(false, 'Unauthorized');
}

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    json_response(false, 'Parameter tidak lengkap');
}

$id = (int)$_GET['id'];
$status = $_GET['status'];

if (!in_array($status, ['diterima', 'ditolak'])) {
    json_response(false, 'Status tidak valid');
}

$allowed = $conn->real_escape_string($status);
$sql = "UPDATE pendaftar SET status = '$allowed' WHERE id = $id";

if ($conn->query($sql)) {
    json_response(true, 'Status berhasil diubah menjadi ' . ucfirst($status));
} else {
    json_response(false, 'Gagal mengubah status');
}
?>