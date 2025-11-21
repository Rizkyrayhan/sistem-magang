<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - LEMIGAS Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .register-container {
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
            .register-container {
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

        .btn-register {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(37, 99, 235, 0.4);
        }

        .btn-register:active {
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
    <div class="register-container">
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

                <!-- Register Form -->
                <div id="register-form">
                    <a href="<?= SITE_URL ?>login" class="hidden md:inline-block text-blue-600 hover:text-blue-800 font-medium text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Buat Akun Baru</h2>
                    <p class="text-gray-600 text-sm mb-6">Daftar sebagai peserta magang</p>

                    <form id="registerForm" class="space-y-3">
                        <div class="input-field">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" id="register-nama" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   placeholder="Nama anda">
                        </div>

                        <div class="input-field">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" id="register-email" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   placeholder="nama@email.com">
                        </div>

                        <div class="input-field">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <input type="password" id="register-password" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   placeholder="Minimal 6 karakter">
                        </div>

                        <div class="input-field">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                            <input type="password" id="register-password_confirm" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   placeholder="Ulangi password">
                        </div>

                        <button type="submit" class="btn-register w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-300 mt-6">
                            <span id="register-btnText">Daftar Sekarang</span>
                            <span id="register-btnLoader" class="hidden">Loading...</span>
                        </button>
                    </form>

                    <!-- Login Link -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-600 text-sm">Sudah punya akun? <a href="<?php echo SITE_URL; ?>login" class="text-blue-600 font-semibold hover:text-blue-700">Login di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Register Form Handler
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const nama = document.getElementById('register-nama').value;
            const email = document.getElementById('register-email').value;
            const password = document.getElementById('register-password').value;
            const password_confirm = document.getElementById('register-password_confirm').value;
            const alert = document.getElementById('alert');
            const btnText = document.getElementById('register-btnText');
            const btnLoader = document.getElementById('register-btnLoader');
            
            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');

            try {
                const response = await fetch('<?php echo SITE_URL; ?>api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ nama, email, password, password_confirm })
                });

                const data = await response.json();

                if (data.success) {
                    alert.className = 'mb-4 p-4 rounded-lg bg-green-100 text-green-700 text-sm font-medium';
                    alert.textContent = data.message;
                    alert.classList.remove('hidden');
                    setTimeout(() => {
                        window.location.href = data.data.redirect;
                    }, 2000);
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