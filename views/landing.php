<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LEMIGAS - Sistem Pendaftaran & Evaluasi Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-section {
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
            .hero-section {
                background: linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(37, 99, 235, 0.98) 100%),
                            url('<?php echo SITE_URL; ?>src/images/background_lemigas3.png') center/cover;
                background-attachment: scroll;
                min-height: auto;
                padding: 40px 20px;
            }
        }

        .hero-content {
            animation: slideUp 0.6s ease-out;
            text-align: center;
            color: white;
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

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.4);
        }

        .btn-secondary {
            border: 2px solid white;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: white;
            color: #3b82f6;
        }

        /* Counter Animation */
        .counter {
            font-size: 3.5rem;
            font-weight: bold;
            line-height: 1;
            min-height: 80px;
        }

        @media (max-width: 640px) {
            .counter {
                font-size: 2.5rem;
                min-height: 65px;
            }
        }

        @media (max-width: 768px) {
            .counter {
                font-size: 3rem;
                min-height: 75px;
            }
        }

        .stat-card {
            text-center;
            padding: 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex items-center space-x-3">
                        <img src="<?php echo SITE_URL; ?>src/images/logo_lemigas.png" alt="Logo LEMIGAS" class="h-10 w-10 object-contain">
                        <span class="font-bold text-xl text-gray-800 hidden sm:inline">LEMIGAS</span>
                    </div>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <a href="<?php echo SITE_URL; ?>login" class="border-2 border-blue-600 rounded-lg text-blue-700 hover:text-gray-900 px-3 py-2 text-sm font-medium">Login</a>
                    <a href="<?php echo SITE_URL; ?>register" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section - Selamat Datang -->
    <div class="hero-section">
        <div class="hero-content max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <!-- Logo Besar -->
            <div class="mb-8 flex justify-center">
                <img src="<?php echo SITE_URL; ?>src/images/logo_lemigas.png" alt="Logo LEMIGAS" class="h-20 w-20 sm:h-32 sm:w-32 md:h-40 md:w-40 object-contain drop-shadow-2xl">
            </div>

            <!-- Judul -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 md:mb-6">
                Selamat Datang di LEMIGAS
            </h1>

            <!-- Subtitle -->
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-blue-100 mb-6 md:mb-8">
                Sistem Pendaftaran & Evaluasi Magang<br>
                Lembaga Minyak dan Gas Bumi - Kementerian ESDM
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                <a href="<?php echo SITE_URL; ?>register" class="bg-white text-blue-600 hover:bg-gray-100 px-6 sm:px-8 py-3 md:py-4 rounded-lg text-base md:text-lg font-semibold shadow-lg transition block">
                    Daftar Sekarang
                </a>
                <a href="<?php echo SITE_URL; ?>login" class="btn-secondary text-white px-6 sm:px-8 py-3 md:py-4 rounded-lg text-base md:text-lg font-semibold transition block">
                    Login
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 md:py-16 lg:py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4">Fitur Unggulan</h2>
                <p class="text-base sm:text-lg text-gray-600">Kelola seluruh proses magang dengan sistem terintegrasi</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 md:p-8">
                    <div class="w-14 h-14 md:w-16 md:h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 md:w-8 md:h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Dashboard Peserta</h3>
                    <p class="text-sm md:text-base text-gray-600">Pantau status pendaftaran dan hasil evaluasi Anda secara real-time</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 md:p-8">
                    <div class="w-14 h-14 md:w-16 md:h-16 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 md:w-8 md:h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v6h16V5a2 2 0 00-2-2H5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Panel Admin</h3>
                    <p class="text-sm md:text-base text-gray-600">Kelola pendaftar, proses evaluasi, dan lihat laporan komprehensif</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 md:p-8">
                    <div class="w-14 h-14 md:w-16 md:h-16 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 md:w-8 md:h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Sistem Evaluasi</h3>
                    <p class="text-sm md:text-base text-gray-600">Penilaian komprehensif mencakup kehadiran, kinerja, dan sikap</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section dengan Counter Animation -->
    <div class="bg-gray-50 py-12 md:py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                <!-- Stat 1: Laboratorium -->
                <div class="stat-card">
                    <p class="text-sm md:text-base text-gray-600 mb-3">Memiliki</p>
                    <div class="text-blue-600 counter" data-target="47" data-suffix="">0</div>
                    <p class="text-sm md:text-base text-gray-600 mt-3">Laboratorium</p>
                </div>

                <!-- Stat 2: Peralatan -->
                <div class="stat-card">
                    <p class="text-sm md:text-base text-gray-600 mb-3">Memiliki</p>
                    <div class="text-green-600 counter" data-target="1560" data-suffix="">0</div>
                    <p class="text-sm md:text-base text-gray-600 mt-3">Peralatan Pengujian</p>
                </div>

                <!-- Stat 3: Pelanggan -->
                <div class="stat-card">
                    <p class="text-sm md:text-base text-gray-600 mb-3">Lebih Dari</p>
                    <div class="text-purple-600 counter" data-target="600" data-suffix="">0</div>
                    <p class="text-sm md:text-base text-gray-600 mt-3">Pelanggan</p>
                </div>

                <!-- Stat 4: Pengujian -->
                <div class="stat-card">
                    <p class="text-sm md:text-base text-gray-600 mb-3">Lebih Dari</p>
                    <div class="text-yellow-600 counter" data-target="1000" data-suffix="">0</div>
                    <p class="text-sm md:text-base text-gray-600 mt-3">Pengujian per Tahun</p>
                </div>
            </div>
        </div>
    </div>

    <!-- About LEMIGAS -->
    <div class="bg-white py-12 md:py-16 lg:py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 items-center">
                <div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4">Tentang LEMIGAS</h2>
                    <p class="text-sm md:text-base text-gray-600 mb-4">
                        LEMIGAS (Lembaga Minyak dan Gas Bumi) adalah lembaga yang berdedikasi untuk pengembangan sumber daya manusia di industri migas Indonesia.
                    </p>
                    <p class="text-sm md:text-base text-gray-600 mb-6">
                        Kami menyediakan program magang berkualitas tinggi yang dirancang untuk memberikan pengalaman praktis kepada mahasiswa dalam industri minyak dan gas bumi.
                    </p>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span class="text-sm md:text-base text-gray-700">Sertifikasi internasional</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span class="text-sm md:text-base text-gray-700">Fasilitas modern dan lengkap</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span class="text-sm md:text-base text-gray-700">Mentor berpengalaman</span>
                        </div>
                    </div>
                </div>
                <div>
                    <img src="<?php echo SITE_URL; ?>src/images/Basic_Cemnting.jpg" alt="LEMIGAS" class="rounded-xl shadow-lg w-full h-auto">
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-12 md:py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 md:mb-4">Siap Bergabung?</h2>
            <p class="text-base sm:text-lg md:text-xl text-blue-100 mb-6 md:mb-8">Daftar sekarang dan mulai perjalanan magang Anda bersama LEMIGAS</p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                <a href="<?php echo SITE_URL; ?>register" class="bg-white text-blue-600 hover:bg-gray-100 px-6 sm:px-8 py-3 md:py-3 rounded-lg font-bold transition inline-block text-sm md:text-base">
                    Daftar Sekarang
                </a>
                <a href="<?php echo SITE_URL; ?>login" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-6 sm:px-8 py-3 md:py-3 rounded-lg font-bold transition inline-block text-sm md:text-base">
                    Login
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-8 md:py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="<?php echo SITE_URL; ?>src/images/logo_lemigas.png" alt="Logo LEMIGAS" class="h-10 w-10 object-contain">
                        <span class="font-bold">LEMIGAS</span>
                    </div>
                    <p class="text-xs md:text-sm">Sistem Pendaftaran & Evaluasi Magang</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-3 md:mb-4 text-sm md:text-base">Menu</h4>
                    <ul class="space-y-2 text-xs md:text-sm">
                        <li><a href="#" class="hover:text-white">Beranda</a></li>
                        <li><a href="#" class="hover:text-white">Tentang</a></li>
                        <li><a href="#" class="hover:text-white">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3 md:mb-4 text-sm md:text-base">Akun</h4>
                    <ul class="space-y-2 text-xs md:text-sm">
                        <li><a href="<?php echo SITE_URL; ?>login" class="hover:text-white">Login</a></li>
                        <li><a href="<?php echo SITE_URL; ?>register" class="hover:text-white">Daftar</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3 md:mb-4 text-sm md:text-base">Kontak</h4>
                    <p class="text-xs md:text-sm">Email: info@lemigas.ac.id</p>
                    <p class="text-xs md:text-sm">Telepon: +62-21-1234567</p>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-xs md:text-sm">
                <p>&copy; 2024 LEMIGAS. Semua hak dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>

    <script>
        // Counter Animation
        function animateCounter() {
            const counters = document.querySelectorAll('.counter');
            
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const suffix = counter.getAttribute('data-suffix') || '';
                let current = 0;
                
                // Duration: 2.5 seconds
                const duration = 2500;
                const increment = target / (duration / 16); // 16ms per frame (60fps)
                
                const updateCounter = () => {
                    current += increment;
                    
                    if (current < target) {
                        counter.textContent = Math.floor(current) + suffix;
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target + suffix;
                    }
                };
                
                updateCounter();
            });
        }

        // Trigger animation ketika section terlihat di viewport
        const statsSection = document.querySelector('.bg-gray-50');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5 // Trigger ketika 50% section terlihat
        });

        observer.observe(statsSection);
    </script>
</body>
</html>