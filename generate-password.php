<?php
/**
 * LEMIGAS Password Hash Generator
 * 
 * Script ini untuk generate password hash yang benar
 * Gunakan untuk membuat SQL INSERT statement dengan hash yang valid
 * 
 * Usage:
 * 1. Buka file ini di browser: http://localhost/lemigas-magang/generate-password.php
 * 2. Masukkan password
 * 3. Copy hash yang di-generate
 * 4. Update SQL query dengan hash tersebut
 */

$generated_hash = null;
$error = null;

// Proses form jika ada input
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['password'])) {
    $password = $_POST['password'];
    
    // Validate password
    if (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter';
    } else {
        // Generate hash
        $generated_hash = password_hash($password, PASSWORD_DEFAULT);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Generator - LEMIGAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">🔐 Password Generator</h1>
            <p class="text-gray-600 text-sm mt-2">Generate hash untuk LEMIGAS Database</p>
        </div>

        <!-- Form Input -->
        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Masukkan password">
                <p class="text-gray-600 text-xs mt-2">Minimal 6 karakter</p>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">
                Generate Hash
            </button>
        </form>

        <!-- Error Message -->
        <?php if ($error): ?>
        <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <p class="text-red-800 text-sm">
                <strong>⚠️ Error:</strong> <?php echo $error; ?>
            </p>
        </div>
        <?php endif; ?>

        <!-- Result -->
        <?php if ($generated_hash): ?>
        <div class="mt-6 space-y-4">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-green-800 text-sm font-semibold mb-2">✅ Hash berhasil di-generate!</p>
            </div>

            <div class="bg-gray-100 rounded-lg p-4 break-all">
                <p class="text-xs text-gray-600 mb-2">Hash (Copy ini):</p>
                <code class="text-sm text-gray-800 font-mono"><?php echo $generated_hash; ?></code>
                <button type="button" onclick="copyToClipboard()" 
                        class="mt-3 w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium transition">
                    📋 Copy ke Clipboard
                </button>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-blue-800 text-sm">
                    <strong>SQL Update Query:</strong>
                </p>
                <code class="text-xs text-blue-900 font-mono mt-2 block break-all">
                    UPDATE users SET password = '<?php echo $generated_hash; ?>' WHERE email = 'your-email@email.com';
                </code>
            </div>
        </div>
        <?php endif; ?>

        <!-- Info Box -->
        <div class="mt-8 bg-blue-50 rounded-lg p-4 space-y-3">
            <p class="text-sm font-semibold text-blue-900">📝 Contoh Password untuk Demo:</p>
            <ul class="text-sm text-blue-800 space-y-1">
                <li>✓ Admin: <code class="bg-white px-2 py-1 rounded">password</code></li>
                <li>✓ Siti: <code class="bg-white px-2 py-1 rounded">password123</code></li>
                <li>✓ Budi: <code class="bg-white px-2 py-1 rounded">password456</code></li>
            </ul>
        </div>

        <!-- SQL Examples -->
        <div class="mt-6 bg-gray-50 rounded-lg p-4">
            <p class="text-sm font-semibold text-gray-800 mb-3">🗄️ SQL Query Examples:</p>
            <div class="space-y-2">
                <details class="text-sm">
                    <summary class="cursor-pointer text-blue-600 hover:text-blue-700 font-medium">
                        Admin User (admin@lemigas.ac.id)
                    </summary>
                    <code class="block bg-white p-2 mt-2 rounded text-xs text-gray-800 break-all overflow-auto max-h-20">
UPDATE users SET password = '[PASTE_HASH_HERE]' WHERE email = 'admin@lemigas.ac.id';
                    </code>
                </details>
                
                <details class="text-sm">
                    <summary class="cursor-pointer text-blue-600 hover:text-blue-700 font-medium">
                        Siti User (siti@mahasiswa.ac.id)
                    </summary>
                    <code class="block bg-white p-2 mt-2 rounded text-xs text-gray-800 break-all overflow-auto max-h-20">
UPDATE users SET password = '[PASTE_HASH_HERE]' WHERE email = 'siti@mahasiswa.ac.id';
                    </code>
                </details>

                <details class="text-sm">
                    <summary class="cursor-pointer text-blue-600 hover:text-blue-700 font-medium">
                        Budi User (budi@mahasiswa.ac.id)
                    </summary>
                    <code class="block bg-white p-2 mt-2 rounded text-xs text-gray-800 break-all overflow-auto max-h-20">
UPDATE users SET password = '[PASTE_HASH_HERE]' WHERE email = 'budi@mahasiswa.ac.id';
                    </code>
                </details>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center text-xs text-gray-500">
            <p>⚠️ Jangan bagikan password hash kepada siapa pun</p>
            <p class="mt-1">🔒 Hash ini aman digunakan di database</p>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const hash = document.querySelector('code').textContent;
            navigator.clipboard.writeText(hash).then(() => {
                alert('✅ Hash berhasil dicopy ke clipboard!');
            }).catch(err => {
                alert('❌ Gagal copy: ' + err);
            });
        }
    </script>
</body>
</html>
