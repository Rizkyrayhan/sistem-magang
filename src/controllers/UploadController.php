<?php
// src/controllers/UploadController.php
// ⚠️ FIXED: Path storage di dalam project folder, bukan di document root

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/helpers/helper.php';

// Proteksi
if (!isLoggedIn() || !isPendaftar()) {
    json_response(false, 'Unauthorized');
}

$user_id = (int)getCurrentUser()['id'];

// ================================================================
// PATH SETUP - PROJECT ROOT (BUKAN DOCUMENT ROOT)
// ================================================================
// __DIR__ = C:\xampppp\htdocs\lemigas-magang\src\controllers
// ../../ = C:\xampppp\htdocs\lemigas-magang

$project_root = realpath(__DIR__ . '/../../');
$storage_base = $project_root . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;

error_log("=== UPLOAD START ===");
error_log("Project root: " . $project_root);
error_log("Storage base: " . $storage_base);
error_log("Storage exists: " . (is_dir($storage_base) ? 'YES' : 'NO'));

// ================================================================
// BUAT FOLDER DENGAN PERMISSION
// ================================================================
$folders = ['foto', 'cv', 'surat', 'ktm'];

foreach ($folders as $folder_name) {
    $dir = $storage_base . $folder_name;
    
    // Jika folder belum ada, buat
    if (!is_dir($dir)) {
        $created = @mkdir($dir, 0777, true);
        
        if (!$created) {
            error_log("GAGAL BUAT FOLDER: $dir");
            json_response(false, "Gagal membuat folder $folder_name");
        }
        
        error_log("FOLDER DIBUAT: $dir");
    }
    
    // Pastikan writable
    if (!is_writable($dir)) {
        @chmod($dir, 0777);
        
        if (!is_writable($dir)) {
            error_log("FOLDER TIDAK WRITABLE: $dir");
            json_response(false, "Folder $folder_name tidak dapat ditulis");
        }
    }
    
    error_log("FOLDER OK: $dir");
}

// ================================================================
// VALIDASI FILE
// ================================================================
$allowed = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
$max_size = 5 * 1024 * 1024; // 5MB

$files_map = [
    'foto'  => ['column' => 'pas_foto',        'folder' => 'foto'],
    'cv'    => ['column' => 'cv_file',         'folder' => 'cv'],
    'surat' => ['column' => 'surat_pengantar', 'folder' => 'surat'],
    'ktm'   => ['column' => 'ktm_file',        'folder' => 'ktm']
];

$updates = [];

foreach ($files_map as $input_name => $config) {
    // Skip jika file tidak di-upload
    if (empty($_FILES[$input_name]['name'])) {
        error_log("SKIP: $input_name (tidak ada file)");
        continue;
    }
    
    $file = $_FILES[$input_name];
    $column = $config['column'];
    $folder = $config['folder'];
    $folder_path = $storage_base . $folder . DIRECTORY_SEPARATOR;
    
    error_log("--- Processing: $input_name ---");
    error_log("File name: " . $file['name']);
    error_log("File size: " . $file['size']);
    error_log("File error code: " . $file['error']);
    error_log("Tmp name: " . $file['tmp_name']);
    error_log("Tmp exists: " . (file_exists($file['tmp_name']) ? 'YES' : 'NO'));
    
    // Cek upload error
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors = [
            UPLOAD_ERR_INI_SIZE   => 'File terlalu besar (upload_max_filesize)',
            UPLOAD_ERR_FORM_SIZE  => 'File terlalu besar (MAX_FILE_SIZE)',
            UPLOAD_ERR_PARTIAL    => 'File hanya terupload sebagian',
            UPLOAD_ERR_NO_FILE    => 'Tidak ada file',
            UPLOAD_ERR_NO_TMP_DIR => 'Tmp folder tidak ada',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file',
            UPLOAD_ERR_EXTENSION  => 'Upload ditolak extension'
        ];
        
        $error_msg = $errors[$file['error']] ?? 'Unknown upload error';
        error_log("ERROR: $error_msg");
        json_response(false, "Upload $input_name gagal: $error_msg");
    }
    
    // Cek ukuran
    if ($file['size'] > $max_size) {
        error_log("ERROR: File terlalu besar");
        json_response(false, "File $input_name terlalu besar (maks 5MB)");
    }
    
    // Cek ekstensi
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        error_log("ERROR: Ekstensi tidak diizinkan: $ext");
        json_response(false, "Format $input_name tidak diizinkan");
    }
    
    // Cek folder writable
    if (!is_dir($folder_path) || !is_writable($folder_path)) {
        error_log("ERROR: Folder tidak writable: $folder_path");
        json_response(false, "Folder $folder tidak dapat ditulis");
    }
    
    // ================================================================
    // GENERATE NAMA FILE & UPLOAD
    // ================================================================
    $new_name = $user_id . '_' . $input_name . '_' . time() . '.' . $ext;
    $full_path = $folder_path . $new_name;
    
    error_log("Upload to: $full_path");
    
    if (move_uploaded_file($file['tmp_name'], $full_path)) {
        @chmod($full_path, 0644);
        
        // Path relative dari project root (untuk database & view-file.php)
        $db_path = 'storage/uploads/' . $folder . '/' . $new_name;
        $updates[$column] = $db_path;
        
        error_log("SUCCESS: File tersimpan");
        error_log("DB path: $db_path");
        error_log("File exists: " . (file_exists($full_path) ? 'YES' : 'NO'));
    } else {
        $error = error_get_last();
        error_log("ERROR: move_uploaded_file gagal");
        if ($error) error_log("Error detail: " . $error['message']);
        json_response(false, "Gagal menyimpan file $input_name");
    }
}

// ================================================================
// SIMPAN TEXT FIELDS
// ================================================================
$text_fields = [
    'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'no_hp', 'alamat',
    'universitas', 'jurusan', 'nim', 'semester', 'ipk', 'bidang_minat',
    'durasi_magang', 'tanggal_mulai', 'alasan'
];

foreach ($text_fields as $field) {
    if (isset($_POST[$field])) {
        $val = trim($_POST[$field]);
        if ($val !== '') {
            $updates[$field] = $val;
        }
    }
}

if (empty($updates)) {
    error_log("INFO: Tidak ada data untuk di-update");
    json_response(true, 'Tidak ada perubahan data');
}

error_log("Updates count: " . count($updates));

// ================================================================
// UPDATE DATABASE
// ================================================================
$types = '';
$params = [];
$set_clauses = [];

foreach ($updates as $col => $val) {
    $set_clauses[] = "`$col` = ?";
    $types .= 's';
    $params[] = $val;
}

$sql = "UPDATE `pendaftar` SET " . implode(', ', $set_clauses) . " WHERE `user_id` = ?";
$types .= 'i';
$params[] = $user_id;

error_log("SQL: $sql");
error_log("User ID: $user_id");

$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("PREPARE ERROR: " . $conn->error);
    json_response(false, 'Database error: ' . $conn->error);
}

$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    error_log("=== UPLOAD SUCCESS ===");
    json_response(true, 'Data dan dokumen berhasil disimpan!');
} else {
    error_log("EXECUTE ERROR: " . $stmt->error);
    json_response(false, 'Gagal simpan: ' . $stmt->error);
}

$stmt->close();
?>