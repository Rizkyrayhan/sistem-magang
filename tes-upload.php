<?php
/**
 * test-upload.php
 * Lokasi: /lemigas-magang/test-upload.php
 * Fungsi: Diagnosa masalah upload file
 * 
 * Akses: http://localhost/lemigas-magang/test-upload.php
 */

echo "<h1>🔍 Diagnostic: Upload File System</h1>";
echo "<hr>";

// 1. Check Document Root
echo "<h2>1. Path Information</h2>";
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$script_dir = dirname(__FILE__);
$storage_base = $doc_root . '/storage/uploads/';

echo "<p><strong>Document Root:</strong> " . htmlspecialchars($doc_root) . "</p>";
echo "<p><strong>Script Dir:</strong> " . htmlspecialchars($script_dir) . "</p>";
echo "<p><strong>Storage Path:</strong> " . htmlspecialchars($storage_base) . "</p>";

// 2. Check Folder Exists
echo "<h2>2. Folder Status</h2>";

$folders = [
    'storage' => $doc_root . '/storage',
    'uploads' => $doc_root . '/storage/uploads',
    'foto' => $doc_root . '/storage/uploads/foto',
    'cv' => $doc_root . '/storage/uploads/cv',
    'surat' => $doc_root . '/storage/uploads/surat',
    'ktm' => $doc_root . '/storage/uploads/ktm'
];

foreach ($folders as $name => $path) {
    $exists = is_dir($path);
    $writable = is_writable($path);
    $perms = @fileperms($path);
    $perms_octal = substr(sprintf('%o', $perms), -3);
    
    $status = $exists ? '✅ ADA' : '❌ TIDAK ADA';
    $write_status = $writable ? '✅ WRITABLE' : '❌ NOT WRITABLE';
    
    echo "<p>";
    echo "<strong>$name:</strong> $status | $write_status | chmod: $perms_octal<br>";
    echo "<code>" . htmlspecialchars($path) . "</code>";
    echo "</p>";
}

// 3. Check PHP Upload Settings
echo "<h2>3. PHP Upload Settings</h2>";

$settings = [
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'file_uploads' => ini_get('file_uploads') ? 'ON' : 'OFF',
    'max_file_uploads' => ini_get('max_file_uploads'),
    'upload_tmp_dir' => ini_get('upload_tmp_dir') ?: '(default /tmp)'
];

foreach ($settings as $key => $value) {
    echo "<p><strong>$key:</strong> $value</p>";
}

// 4. Check Temp Directory
echo "<h2>4. Temporary Directory Status</h2>";

$tmp_dir = ini_get('upload_tmp_dir') ?: '/tmp';
if (!$tmp_dir) $tmp_dir = sys_get_temp_dir();

$tmp_exists = is_dir($tmp_dir);
$tmp_writable = is_writable($tmp_dir);

echo "<p><strong>Temp Dir:</strong> " . htmlspecialchars($tmp_dir) . "</p>";
echo "<p><strong>Exists:</strong> " . ($tmp_exists ? '✅ YES' : '❌ NO') . "</p>";
echo "<p><strong>Writable:</strong> " . ($tmp_writable ? '✅ YES' : '❌ NO') . "</p>";

// 5. Check view-file.php
echo "<h2>5. View-File Handler</h2>";

$view_file_path = $doc_root . '/view-file.php';
$view_exists = file_exists($view_file_path);

echo "<p><strong>view-file.php exists:</strong> " . ($view_exists ? '✅ YES' : '❌ NO') . "</p>";
if (!$view_exists) {
    echo "<p style='color:red;'><strong>⚠️ PENTING:</strong> File view-file.php tidak ditemukan! Buat file ini terlebih dahulu.</p>";
}

// 6. Test Simple Upload/storage/uploads/test/
echo "<h2>6. Simple Upload Test</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES['test_file'])) {
    $file = $_FILES['test_file'];
    $test_dir = $doc_root . '/lemigas-magang/storage/uploads/test/';
    
    // Buat folder test jika belum ada
    if (!is_dir($test_dir)) {
        @mkdir($test_dir, 0777, true);
    }
    
    $test_file_path = $test_dir . basename($file['name']);
    
    echo "<p><strong>File Name:</strong> " . htmlspecialchars($file['name']) . "</p>";
    echo "<p><strong>File Size:</strong> " . $file['size'] . " bytes</p>";
    echo "<p><strong>File Error:</strong> " . $file['error'] . "</p>";
    echo "<p><strong>Dest Path:</strong> " . htmlspecialchars($test_file_path) . "</p>";
    
    if (move_uploaded_file($file['tmp_name'], $test_file_path)) {
        @chmod($test_file_path, 0644);
        echo "<p style='color:green;'><strong>✅ SUCCESS!</strong> File berhasil diupload ke " . htmlspecialchars($test_file_path) . "</p>";
        
        // Cek file ada
        if (file_exists($test_file_path)) {
            echo "<p style='color:green;'>✅ File terverifikasi ada di disk</p>";
        }
    } else {
        $error = error_get_last();
        echo "<p style='color:red;'><strong>❌ UPLOAD FAILED!</strong></p>";
        echo "<p>Error: " . ($error['message'] ?? 'Unknown') . "</p>";
    }
} else {
    echo "<form method='post' enctype='multipart/form-data'>";
    echo "<input type='file' name='test_file' required>";
    echo "<button type='submit'>Upload Test File</button>";
    echo "</form>";
}

// 7. Recommendations
echo "<h2>7. Rekomendasi</h2>";

$issues = [];

foreach ($folders as $name => $path) {
    if (!is_dir($path)) {
        $issues[] = "❌ Folder <code>$name</code> tidak ada. Buat dengan: <code>mkdir -p " . htmlspecialchars($path) . "</code>";
    } elseif (!is_writable($path)) {
        $issues[] = "❌ Folder <code>$name</code> tidak writable. Jalankan: <code>chmod 777 " . htmlspecialchars($path) . "</code>";
    }
}

if (!$view_exists) {
    $issues[] = "❌ File <code>view-file.php</code> tidak ada di root project. Buat file ini menggunakan code dari artifact.";
}

if (empty($issues)) {
    echo "<p style='color:green;'><strong>✅ Semua OK!</strong> Sistem siap untuk upload.</p>";
} else {
    echo "<ol style='color:red;'>";
    foreach ($issues as $issue) {
        echo "<li>" . $issue . "</li>";
    }
    echo "</ol>";
}

echo "<hr>";
echo "<p><small>Last updated: " . date('Y-m-d H:i:s') . "</small></p>";
?>