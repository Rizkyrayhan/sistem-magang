<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LEMIGAS - Sistem Pendaftaran & Evaluasi Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="flex items-center space-x-3">
                            <!-- LOGO BARU -->
                            <img src="<?php echo SITE_URL; ?>src/images/logo_lemigas.png" alt="Logo LEMIGAS" class="h-10 w-10 object-contain">
                            <span class="font-bold text-xl text-gray-800">LEMIGAS</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?php echo SITE_URL; ?>login" class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium">Login</a>
                    <a href="<?php echo SITE_URL; ?>register" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="absolute w-96 h-96 -top-12 -right-12" fill="currentColor" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="50"/>
            </svg>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="text-center">
                <!-- LOGO BESAR DI TENGAH -->
                <div class="mb-8 flex justify-center">
                    <img src="<?php echo SITE_URL; ?>src/images/logo_lemigas.png" alt="Logo LEMIGAS" class="h-32 w-32 md:h-40 md:w-40 object-contain drop-shadow-2xl">
                </div>
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Selamat Datang di LEMIGAS
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                    Sistem Pendaftaran & Evaluasi Magang<br>
                    Lembaga Minyak dan Gas Bumi - Kementerian ESDM
                </p>
                <div class="space-x-4">
                    <a href="<?php echo SITE_URL; ?>register" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold shadow-lg transition">
                        Daftar Sekarang
                    </a>
                    <a href="<?php echo SITE_URL; ?>login" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold transition">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
                <div class="hidden md:block">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Pendaftaran Mudah</p>
                                    <p class="text-gray-600 text-sm">Proses pendaftaran yang sederhana dan cepat</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Evaluasi Transparan</p>
                                    <p class="text-gray-600 text-sm">Sistem penilaian yang adil dan objektif</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Data Aman</p>
                                    <p class="text-gray-600 text-sm">Informasi Anda tersimpan dengan aman</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">500+</div>
                    <p class="text-gray-600">Peserta Magang</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-600 mb-2">50+</div>
                    <p class="text-gray-600">Perusahaan Mitra</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">95%</div>
                    <p class="text-gray-600">Kepuasan Pengguna</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-yellow-600 mb-2">10+</div>
                    <p class="text-gray-600">Tahun Berpengalaman</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600">Kelola seluruh proses magang dengan sistem terintegrasi</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Dashboard Peserta</h3>
                    <p class="text-gray-600">Pantau status pendaftaran dan hasil evaluasi Anda secara real-time</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-8">
                    <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v6h16V5a2 2 0 00-2-2H5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Panel Admin</h3>
                    <p class="text-gray-600">Kelola pendaftar, proses evaluasi, dan lihat laporan komprehensif</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-8">
                    <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Sistem Evaluasi</h3>
                    <p class="text-gray-600">Penilaian komprehensif mencakup kehadiran, kinerja, dan sikap</p>
                </div>
            </div>
        </div>
    </div>

    <!-- About LEMIGAS -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Tentang LEMIGAS</h2>
                    <p class="text-gray-600 mb-4">
                        LEMIGAS (Lembaga Minyak dan Gas Bumi) adalah lembaga yang berdedikasi untuk pengembangan sumber daya manusia di industri migas Indonesia.
                    </p>
                    <p class="text-gray-600 mb-4">
                        Kami menyediakan program magang berkualitas tinggi yang dirancang untuk memberikan pengalaman praktis kepada mahasiswa dalam industri minyak dan gas bumi.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span class="text-gray-700">Sertifikasi internasional</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span class="text-gray-700">Fasilitas modern dan lengkap</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span class="text-gray-700">Mentor berpengalaman</span>
                        </div>
                    </div>
                </div>
                <div>
                    <img src="<?php echo SITE_URL; ?>src/images/Basic_Cemnting.jpg" alt="LEMIGAS" class="rounded-xl shadow-lg w-full">
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Bergabung?</h2>
            <p class="text-xl text-blue-100 mb-8">Daftar sekarang dan mulai perjalanan magang Anda bersama LEMIGAS</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo SITE_URL; ?>register" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-bold transition inline-block">
                    Daftar Sekarang
                </a>
                <a href="<?php echo SITE_URL; ?>login" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-3 rounded-lg font-bold transition inline-block">
                    Login
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
<img src="<?php echo SITE_URL; ?>src/images/logo_lemigas.png" alt="Logo LEMIGAS" class="h-10 w-10 object-contain">
                        <span class="font-bold">LEMIGAS</span>
                    </div>
                    <p class="text-sm">Sistem Pendaftaran & Evaluasi Magang</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Menu</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Beranda</a></li>
                        <li><a href="#" class="hover:text-white">Tentang</a></li>
                        <li><a href="#" class="hover:text-white">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Akun</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?php echo SITE_URL; ?>login" class="hover:text-white">Login</a></li>
                        <li><a href="<?php echo SITE_URL; ?>register" class="hover:text-white">Daftar</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <p class="text-sm">Email: info@lemigas.ac.id</p>
                    <p class="text-sm">Telepon: +62-21-1234567</p>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-sm">
                <p>&copy; 2024 LEMIGAS. Semua hak dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>
</body>
</html>