<?php
// session_start();

// Path yang benar setelah routing tanpa .htaccess
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/helpers/helper.php';

$action = $_GET['action'] ?? '';

if ($action === 'login') {
    loginProcess();
} elseif ($action === 'register') {
    registerProcess();
} elseif ($action === 'logout') {
    session_destroy();
    redirect('login');
}

function loginProcess() {
    global $conn;
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        json_response(false, 'Invalid request method');
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    $email = trim($data['email'] ?? '');
    $password = trim($data['password'] ?? '');
    
    if (empty($email) || empty($password)) {
        json_response(false, 'Email dan password harus diisi');
    }
    
    $email = $conn->real_escape_string($email);
    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    
    if ($result->num_rows === 0) {
        json_response(false, 'Email atau password salah');
    }
    
    $user = $result->fetch_assoc();
    
    if (!password_verify($password, $user['password'])) {
        json_response(false, 'Email atau password salah');
    }
    
    $_SESSION['user'] = [
        'id'    => $user['id'],
        'email' => $user['email'],
        'nama'  => $user['nama'],
        'role'  => $user['role']
    ];
    
    $redirect = $user['role'] === 'admin' ? 'admin/dashboard' : 'user/dashboard';
    json_response(true, 'Login berhasil', ['redirect' => SITE_URL . $redirect]);
}

function registerProcess() {
    global $conn;
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        json_response(false, 'Invalid request method');
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    $email = trim($data['email'] ?? '');
    $password = trim($data['password'] ?? '');
    $password_confirm = trim($data['password_confirm'] ?? '');
    $nama = trim($data['nama'] ?? '');
    
    // Validasi
    if (empty($email) || empty($password) || empty($nama)) {
        json_response(false, 'Semua field harus diisi');
    }
    
    if (strlen($password) < 6) {
        json_response(false, 'Password minimal 6 karakter');
    }
    
    if ($password !== $password_confirm) {
        json_response(false, 'Konfirmasi password tidak sesuai');
    }
    
    $email_escaped = $conn->real_escape_string($email);
    $check = $conn->query("SELECT id FROM users WHERE email = '$email_escaped'");
    if ($check->num_rows > 0) {
        json_response(false, 'Email sudah terdaftar');
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $nama_escaped = $conn->real_escape_string($nama);
    
    $sql = "INSERT INTO users (email, password, nama, role) VALUES ('$email_escaped', '$hashedPassword', '$nama_escaped', 'pendaftar')";
    
    if ($conn->query($sql)) {
        $user_id = $conn->insert_id;
        $conn->query("INSERT INTO pendaftar (user_id, status) VALUES ($user_id, 'menunggu')");
        json_response(true, 'Registrasi berhasil! Silakan login', ['redirect' => SITE_URL . 'login']);
    } else {
        json_response(false, 'Registrasi gagal: ' . $conn->error);
    }
}
?>