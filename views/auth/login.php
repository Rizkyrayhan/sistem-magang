<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LEMIGAS Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden max-w-4xl w-full grid grid-cols-1 md:grid-cols-2">
            <!-- Left Side - Branding -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white p-8 flex flex-col justify-center hidden md:flex">
                <div class="mb-8">
                    <div class="w-20 h-20 bg-white rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 4h16v2H4V4zm0 7h16v2H4v-2zm0 7h16v2H4v-2z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold">LEMIGAS</h1>
                    <p class="text-blue-100 text-sm mt-2">Sistem Pendaftaran & Evaluasi Magang</p>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-200 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        <p class="text-sm text-blue-100">Kelola pendaftaran dengan mudah</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-200 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        <p class="text-sm text-blue-100">Evaluasi transparan dan efisien</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-200 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        <p class="text-sm text-blue-100">Hasil evaluasi tercatat dengan aman</p>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="p-8 md:p-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang!</h2>
                <p class="text-gray-600 mb-8">Silakan login untuk melanjutkan</p>

                <div id="alert" class="hidden mb-4 p-4 rounded-lg"></div>

                <form id="loginForm" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="nama@email.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" id="password" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-300 mt-8">
                        <span id="btnText">Login Sekarang</span>
                        <span id="btnLoader" class="hidden">Loading...</span>
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600 text-sm">Belum punya akun? <a href="<?php echo SITE_URL; ?>register" class="text-blue-600 font-semibold hover:text-blue-700">Daftar Sekarang</a></p>
                </div>

                <!-- Demo Credentials -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <p class="text-xs text-gray-500 font-semibold mb-3">Demo Credentials:</p>
                    <div class="space-y-2 text-xs">
                        <div class="bg-blue-50 p-3 rounded">
                            <p class="font-semibold text-blue-900">Admin:</p>
                            <p class="text-blue-700">admin@lemigas.ac.id / admin123</p>
                        </div>
                        <div class="bg-green-50 p-3 rounded">
                            <p class="font-semibold text-green-900">Peserta:</p>
                            <p class="text-green-700">siti@mahasiswa.ac.id / password123</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const alert = document.getElementById('alert');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');
            
            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');

            try {
                const response = await fetch('<?php echo SITE_URL; ?>api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();

                if (data.success) {
                    alert.className = 'mb-4 p-4 rounded-lg bg-green-100 text-green-700';
                    alert.textContent = data.message;
                    alert.classList.remove('hidden');
                    setTimeout(() => {
                        window.location.href = data.data.redirect;
                    }, 1000);
                } else {
                    alert.className = 'mb-4 p-4 rounded-lg bg-red-100 text-red-700';
                    alert.textContent = data.message;
                    alert.classList.remove('hidden');
                }
            } catch (error) {
                alert.className = 'mb-4 p-4 rounded-lg bg-red-100 text-red-700';
                alert.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                alert.classList.remove('hidden');
            } finally {
                btnText.classList.remove('hidden');
                btnLoader.classList.add('hidden');
            }
        });
    </script>
</body>
</html>