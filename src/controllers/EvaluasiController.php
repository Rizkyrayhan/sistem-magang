<?php
// src/controllers/EvaluasiController.php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/helpers/helper.php';

if (!isAdmin()) {
    json_response(false, 'Akses ditolak. Admin only.');
}

// Hanya terima POST JSON
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method tidak diizinkan');
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    json_response(false, 'Data JSON tidak valid');
}

$pendaftar_id   = (int)($data['pendaftar_id'] ?? 0);
$kehadiran      = (int)($data['nilai_kehadiran'] ?? 0);
$kinerja        = (int)($data['nilai_kinerja'] ?? 0);
$sikap          = (int)($data['nilai_sikap'] ?? 0);
$komentar       = $conn->real_escape_string($data['komentar'] ?? '');

if ($pendaftar_id <= 0 || $kehadiran < 0 || $kehadiran > 100 || $kinerja < 0 || $kinerja > 100 || $sikap < 0 || $sikap > 100) {
    json_response(false, 'Data tidak valid atau nilai di luar rentang 0-100');
}

$rata_rata = round(($kehadiran + $kinerja + $sikap) / 3, 2);

// Cek apakah sudah ada evaluasi
$check = $conn->query("SELECT id FROM evaluasi WHERE pendaftar_id = $pendaftar_id");

if ($check && $check->num_rows > 0) {
    // UPDATE
    $sql = "UPDATE evaluasi SET 
            nilai_kehadiran = $kehadiran,
            nilai_kinerja = $kinerja,
            nilai_sikap = $sikap,
            rata_rata = $rata_rata,
            komentar = '$komentar',
            status = 'selesai',
            updated_at = NOW()
            WHERE pendaftar_id = $pendaftar_id";
} else {
    // INSERT
    $sql = "INSERT INTO evaluasi 
            (pendaftar_id, nilai_kehadiran, nilai_kinerja, nilai_sikap, rata_rata, komentar, status, created_at)
            VALUES 
            ($pendaftar_id, $kehadiran, $kinerja, $sikap, $rata_rata, '$komentar', 'selesai', NOW())";
}

if ($conn->query($sql)) {
    json_response(true, 'Evaluasi berhasil disimpan! Nilai akhir: ' . $rata_rata);
} else {
    json_response(false, 'Gagal simpan ke database: ' . $conn->error);
}
?>