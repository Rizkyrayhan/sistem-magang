<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LEMIGAS Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .login-container {
            background: linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(37, 99, 235, 0.95) 100%),
                        url('<?php echo SITE_URL; ?>src/images/background_lemigas3.png') center/cover;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .login-container {
                background: linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(37, 99, 235, 0.98) 100%),
                            url('<?php echo SITE_URL; ?>src/images/background_lemigas3.png') center/cover;
                background-attachment: scroll;
            }
        }

        .form-card {
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .input-field {
            position: relative;
        }

        .input-field input {
            transition: all 0.3s ease;
        }

        .input-field input:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(37, 99, 235, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .stats-item {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stats-item h3 {
            font-size: 28px;
            font-weight: bold;
            color: white;
        }

        .stats-item p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="login-container">
        <!-- Left Side - Stats (Hidden on Mobile) -->
        <div class="hidden lg:flex flex-1 flex-col justify-center items-center px-8 text-white">
            <div class="mb-12 text-center">
                <img src="<?php echo SITE_URL; ?>src/images/logo_lemigas.png" alt="LEMIGAS Logo" class="w-28 h-28 mx-auto mb-6 object-contain">
                <h1 class="text-5xl font-bold mb-4">LEMIGAS</h1>
                <p class="text-xl opacity-90">Sistem Pendaftaran & Evaluasi Magang</p>
            </div>

            <div class="grid grid-cols-3 gap-6 w-full max-w-md">
                <div class="stats-item">
                    <h3>500+</h3>
                    <p>Mahasiswa</p>
                </div>
                <div class="stats-item">
                    <h3>50+</h3>
                    <p>Perusahaan</p>
                </div>
                <div class="stats-item">
                    <h3>95%</h3>
                    <p>Keberhasilan</p>
                </div>
            </div>

            <div class="mt-12 space-y-4 text-sm text-center max-w-md">
                <div class="flex items-center opacity-90">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    <span>Kelola pendaftaran dengan mudah</span>
                </div>
                <div class="flex items-center opacity-90">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    <span>Evaluasi transparan dan efisien</span>
                </div>
                <div class="flex items-center opacity-90">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    <span>Hasil evaluasi tercatat dengan aman</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="flex-1 flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="form-card bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 sm:p-8 lg:p-10">
                <!-- Logo Mobile -->
                <div class="lg:hidden mb-6">
                    <div class="logo-icon">
                        <img src="<?php echo SITE_URL; ?>src/images/logo_lemigas.png" alt="LEMIGAS Logo" class="w-17 h-17 object-contain">
                    </div>
                    <h1 class="text-center text-2xl font-bold text-gray-800 mt-4">LEMIGAS</h1>
                </div>

                <!-- Alert -->
                <div id="alert" class="hidden mb-4 p-4 rounded-lg text-sm font-medium"></div>

                <!-- Login Form -->
                <div id="login-form">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang!</h2>
                    <p class="text-gray-600 text-sm mb-6">Silakan login untuk melanjutkan</p>

                    <form id="loginForm" class="space-y-4">
                        <div class="input-field">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" id="login-email" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   placeholder="nama@email.com">
                        </div>

                        <div class="input-field">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <input type="password" id="login-password" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   placeholder="••••••••">
                        </div>

                        <button type="submit" class="btn-login w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-300 mt-6">
                            <span id="login-btnText">Login</span>
                            <span id="login-btnLoader" class="hidden">Loading...</span>
                        </button>
                    </form>

                    <!-- Register Link -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-600 text-sm">Belum punya akun? <a href="<?php echo SITE_URL; ?>register" class="text-blue-600 font-semibold hover:text-blue-700">Daftar di sini</a></p>
                    </div>

                    <!-- Demo Credentials -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <p class="text-xs text-gray-500 font-semibold mb-4">Demo Credentials:</p>
                        <div class="space-y-3 text-xs">
                            <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                                <p class="font-semibold text-blue-900">👤 Admin:</p>
                                <p class="text-blue-700 mt-1">admin@lemigas.ac.id</p>
                                <p class="text-blue-700">password</p>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg border border-green-100">
                                <p class="font-semibold text-green-900">👨‍🎓 Peserta:</p>
                                <p class="text-green-700 mt-1">siti@mahasiswa.ac.id</p>
                                <p class="text-green-700">password123</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Login Form Handler
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            const alert = document.getElementById('alert');
            const btnText = document.getElementById('login-btnText');
            const btnLoader = document.getElementById('login-btnLoader');
            
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
                    alert.className = 'mb-4 p-4 rounded-lg bg-green-100 text-green-700 text-sm font-medium';
                    alert.textContent = data.message;
                    alert.classList.remove('hidden');
                    setTimeout(() => {
                        window.location.href = data.data.redirect;
                    }, 1000);
                } else {
                    alert.className = 'mb-4 p-4 rounded-lg bg-red-100 text-red-700 text-sm font-medium';
                    alert.textContent = data.message;
                    alert.classList.remove('hidden');
                }
            } catch (error) {
                alert.className = 'mb-4 p-4 rounded-lg bg-red-100 text-red-700 text-sm font-medium';
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