<?php
// session_start();
require_once '../../config.php';
require_once '../../src/helpers/helper.php';

$action = $_GET['action'] ?? '';

if ($action === 'simpan') {
    simpanEvaluasiProcess();
}

function simpanEvaluasiProcess() {
    global $conn;
    
    if (!isAdmin()) {
        json_response(false, 'Unauthorized - Admin only');
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $pendaftar_id = (int)$data['pendaftar_id'];
    $nilai_kehadiran = (int)$data['nilai_kehadiran'];
    $nilai_kinerja = (int)$data['nilai_kinerja'];
    $nilai_sikap = (int)$data['nilai_sikap'];
    $komentar = $conn->real_escape_string($data['komentar'] ?? '');
    
    // Validasi nilai
    if ($nilai_kehadiran < 0 || $nilai_kehadiran > 100 ||
        $nilai_kinerja < 0 || $nilai_kinerja > 100 ||
        $nilai_sikap < 0 || $nilai_sikap > 100) {
        json_response(false, 'Nilai harus antara 0-100');
    }
    
    // Hitung rata-rata
    $rata_rata = ($nilai_kehadiran + $nilai_kinerja + $nilai_sikap) / 3;
    
    // Check if evaluasi exists
    $check = $conn->query("SELECT id FROM evaluasi WHERE pendaftar_id = $pendaftar_id");
    
    if ($check->num_rows > 0) {
        $result = $conn->query("UPDATE evaluasi SET 
                               nilai_kehadiran = $nilai_kehadiran,
                               nilai_kinerja = $nilai_kinerja,
                               nilai_sikap = $nilai_sikap,
                               rata_rata = $rata_rata,
                               komentar = '$komentar',
                               status = 'selesai'
                               WHERE pendaftar_id = $pendaftar_id");
    } else {
        $result = $conn->query("INSERT INTO evaluasi 
                               (pendaftar_id, nilai_kehadiran, nilai_kinerja, nilai_sikap, rata_rata, komentar, status)
                               VALUES 
                               ($pendaftar_id, $nilai_kehadiran, $nilai_kinerja, $nilai_sikap, $rata_rata, '$komentar', 'selesai')");
    }
    
    if ($result) {
        json_response(true, 'Evaluasi berhasil disimpan');
    } else {
        json_response(false, 'Gagal menyimpan evaluasi: ' . $conn->error);
    }
}

?>