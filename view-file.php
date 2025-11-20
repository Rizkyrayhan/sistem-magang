<?php
// view-file.php
// ============================================================
// Lokasi: C:\xampppp\htdocs\lemigas-magang\view-file.php
// ============================================================
// Fungsi: Handle viewing/download file yang diupload
// Akses via: http://localhost/lemigas-magang/view-file.php?file=storage/uploads/foto/123_foto_xxx.jpg

session_start();

// Validasi parameter
if (empty($_GET['file'])) {
    http_response_code(400);
    die('Bad request');
}

$requested_file = urldecode($_GET['file']);

// ============================================================
// KEAMANAN: Path harus dalam folder uploads
// ============================================================

// Project root = tempat view-file.php berada
$project_root = __DIR__;
$storage_dir = $project_root . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;

// Buat path absolut
$full_path = realpath($project_root . DIRECTORY_SEPARATOR . $requested_file);

// Cek path validity (anti directory traversal attack)
if (!$full_path || strpos($full_path, realpath($storage_dir)) !== 0) {
    http_response_code(403);
    die('Access denied');
}

// Validasi file ada & readable
if (!file_exists($full_path) || !is_file($full_path) || !is_readable($full_path)) {
    http_response_code(404);
    die('File not found');
}

// ============================================================
// SERVE FILE
// ============================================================

// Deteksi MIME type
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($finfo, $full_path);
finfo_close($finfo);

// Fallback MIME type jika detection gagal
if (!$mime_type) {
    $ext = strtolower(pathinfo($full_path, PATHINFO_EXTENSION));
    $mime_types = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    $mime_type = $mime_types[$ext] ?? 'application/octet-stream';
}

// Set headers
header('Content-Type: ' . $mime_type);
header('Content-Length: ' . filesize($full_path));
header('Content-Disposition: inline; filename="' . basename($full_path) . '"');
header('Cache-Control: public, max-age=3600');
header('Pragma: public');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');

// Output file
readfile($full_path);
exit;
?>