<?php
// session_start();

require_once __DIR__ . '/../../config.php';           // ← diperbaiki
require_once __DIR__ . '/../../src/helpers/helper.php'; // ← diperbaiki

$action = $_GET['action'] ?? '';

if ($action === 'getPendaftar') {
    getPendaftarProcess();
} elseif ($action === 'tambah') {
    tambahPendaftarProcess();
}

// ... sisanya tetap sama seperti kode kamu sebelumnya

function getPendaftarProcess() {
    global $conn;
    
    $status = $_GET['status'] ?? null;
    $search = $_GET['search'] ?? null;
    
    $query = "SELECT p.*, u.nama, u.email FROM pendaftar p 
              JOIN users u ON p.user_id = u.id WHERE 1=1";
    
    if ($status && $status !== 'semua') {
        $query .= " AND p.status = '$status'";
    }
    
    if ($search) {
        $search = $conn->real_escape_string($search);
        $query .= " AND (u.nama LIKE '%$search%' OR u.email LIKE '%$search%' OR p.nim LIKE '%$search%')";
    }
    
    $query .= " ORDER BY p.tanggal_daftar DESC";
    
    $result = $conn->query($query);
    $pendaftar = $result->fetch_all(MYSQLI_ASSOC);
    
    json_response(true, 'Data loaded', ['pendaftar' => $pendaftar]);
}

function tambahPendaftarProcess() {
    global $conn;
    
    $user = getCurrentUser();
    if (!$user) {
        json_response(false, 'Unauthorized');
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $user_id = $user['id'];
    $nim = $conn->real_escape_string($data['nim'] ?? '');
    $tempat_tanggal_lahir = $conn->real_escape_string($data['tempat_tanggal_lahir'] ?? '');
    $jurusan = $conn->real_escape_string($data['jurusan'] ?? '');
    $universitas = $conn->real_escape_string($data['universitas'] ?? '');
    $bidang_minat = $conn->real_escape_string($data['bidang_minat'] ?? '');
    $no_hp = $conn->real_escape_string($data['no_hp'] ?? '');
    $alamat = $conn->real_escape_string($data['alamat'] ?? '');
    
    // Check if already registered
    $check = $conn->query("SELECT id FROM pendaftar WHERE user_id = $user_id");
    
    if ($check->num_rows > 0) {
        $result = $conn->query("UPDATE pendaftar SET 
                               nim = '$nim',
                               tempat_tanggal_lahir = '$tempat_tanggal_lahir',
                               jurusan = '$jurusan',
                               universitas = '$universitas',
                               bidang_minat = '$bidang_minat',
                               no_hp = '$no_hp',
                               alamat = '$alamat'
                               WHERE user_id = $user_id");
    } else {
        $result = $conn->query("INSERT INTO pendaftar 
                               (user_id, nim, tempat_tanggal_lahir, jurusan, universitas, bidang_minat, no_hp, alamat, status)
                               VALUES 
                               ($user_id, '$nim', '$tempat_tanggal_lahir', '$jurusan', '$universitas', '$bidang_minat', '$no_hp', '$alamat', 'menunggu')");
    }
    
    if ($result) {
        json_response(true, 'Data pendaftar berhasil disimpan');
    } else {
        json_response(false, 'Gagal menyimpan data: ' . $conn->error);
    }
}

?>