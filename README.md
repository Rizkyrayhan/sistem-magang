# 🎓 LEMIGAS - Sistem Pendaftaran & Evaluasi Magang

![Status](https://img.shields.io/badge/Status-Active-brightgreen)
![Version](https://img.shields.io/badge/Version-1.0.0-blue)
![License](https://img.shields.io/badge/License-MIT-green)

Sistem informasi terintegrasi untuk manajemen pendaftaran dan evaluasi magang di Lembaga Minyak dan Gas Bumi (LEMIGAS).

---

## 📋 Daftar Isi
- [Fitur](#fitur)
- [Tech Stack](#tech-stack)
- [Instalasi](#instalasi)
- [Penggunaan](#penggunaan)
- [Struktur Folder](#struktur-folder)
- [API Documentation](#api-documentation)
- [Demo Account](#demo-account)
- [Troubleshooting](#troubleshooting)

---

## ✨ Fitur

### 👨‍💼 Admin Dashboard
- ✅ Dashboard dengan statistik lengkap
- ✅ Kelola data pendaftar (CRUD)
- ✅ Search & filter pendaftar
- ✅ Form evaluasi dengan rating scale 0-100
- ✅ 3 kriteria penilaian (Kehadiran, Kinerja, Sikap)
- ✅ Perhitungan otomatis rata-rata nilai
- ✅ Laporan & analisis data
- ✅ Export data ke Excel/CSV

### 👨‍🎓 Peserta Dashboard
- ✅ Dashboard dengan info status
- ✅ Timeline status pendaftaran
- ✅ Edit & submit data pendaftaran
- ✅ Lihat hasil evaluasi
- ✅ Download hasil evaluasi

### 🔐 Sistem Autentikasi
- ✅ Login dengan email & password
- ✅ Register akun baru
- ✅ Password hashing dengan bcrypt
- ✅ Session management
- ✅ Role-based access (Admin & Pendaftar)

### 📊 Fitur Lainnya
- ✅ Responsive design (Mobile, Tablet, Desktop)
- ✅ Modern UI dengan Tailwind CSS
- ✅ Real-time validation
- ✅ Error handling yang baik
- ✅ Security best practices

---

## 🛠️ Tech Stack

### Backend
- **PHP** 7.4+
- **MySQL/MariaDB** 5.7+
- **Apache** (dengan mod_rewrite)

### Frontend
- **HTML5**
- **CSS3**
- **JavaScript (ES6+)**
- **Tailwind CSS**

### Tools
- **Git** untuk version control
- **Composer** (optional)
- **NPM** (optional)

---

## 📥 Instalasi

### Prasyarat
```
✓ PHP >= 7.4
✓ MySQL >= 5.7
✓ Apache dengan mod_rewrite
✓ XAMPP / WAMP / LAMP
```

### Step 1: Clone / Download
```bash
# Clone dari repository
git clone https://github.com/username/lemigas-magang.git

# Atau download ZIP dan extract
```

### Step 2: Setup Database
```bash
# Database akan otomatis dibuat saat aplikasi pertama kali dijalankan
# Atau buat manual di phpMyAdmin dengan nama: lemigas_magang
```

### Step 3: Konfigurasi
Edit `config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'lemigas_magang');
```

### Step 4: Run
```bash
# Via XAMPP: Start Apache & MySQL
# Atau via Terminal:
php -S localhost:8000

# Akses di browser:
http://localhost/lemigas-magang/
```

**Untuk dokumentasi lengkap, lihat file [SETUP.md](SETUP.md)**

---

## 🚀 Penggunaan

### Login Admin
```
Email: admin@lemigas.ac.id
Password: password
```

### Login Peserta
```
Email: siti@mahasiswa.ac.id
Password: password123
```

### Halaman Utama
- **Landing Page**: `http://localhost/lemigas-magang/`
- **Login**: `http://localhost/lemigas-magang/login`
- **Register**: `http://localhost/lemigas-magang/register`

### Admin Routes
- Dashboard: `/admin/dashboard`
- Data Pendaftar: `/admin/data-pendaftar`
- Form Evaluasi: `/admin/evaluasi`
- Laporan: `/admin/laporan`

### User Routes
- Dashboard: `/user/dashboard`
- Status Pendaftaran: `/user/status-pendaftaran`
- Hasil Evaluasi: `/user/hasil-evaluasi`

---

## 📁 Struktur Folder

```
lemigas-magang/
├── public/
│   ├── css/                    # CSS files
│   ├── js/                     # JavaScript files
│   └── images/                 # Images & assets
├── src/
│   ├── config/                 # Database config (optional)
│   ├── controllers/            # Business logic
│   │   ├── AuthController.php
│   │   ├── DaftarController.php
│   │   └── EvaluasiController.php
│   ├── helpers/               # Helper functions
│   │   └── helper.php
│   ├── models/                # Data models (optional)
│   └── middleware/            # Middleware (optional)
├── views/
│   ├── auth/                  # Login & Register
│   ├── admin/                 # Admin pages
│   ├── user/                  # User pages
│   ├── components/            # Reusable components
│   └── landing.php            # Landing page
├── database/                  # Database scripts
│   ├── migrations/
│   └── seeds/
├── storage/                   # Uploads & logs
│   ├── uploads/
│   ├── logs/
│   └── cache/
├── index.php                  # Entry point
├── config.php                 # Configuration
├── .htaccess                  # URL rewriting
├── .gitignore                 # Git config
└── README.md                  # Documentation
```

---

## 🔌 API Documentation

### Authentication API

**POST** `/api/login`
```json
{
  "email": "admin@lemigas.ac.id",
  "password": "password"
}
```

**POST** `/api/register`
```json
{
  "nama": "John Doe",
  "email": "john@email.com",
  "password": "password123",
  "password_confirm": "password123"
}
```

### Pendaftar API

**GET** `/api/get-pendaftar?status=menunggu`
```json
{
  "success": true,
  "data": {
    "pendaftar": [...]
  }
}
```

**POST** `/api/tambah-pendaftar`
```json
{
  "nim": "2021001234",
  "tempat_tanggal_lahir": "Jakarta, 1 Januari 2000",
  "jurusan": "Teknik Informatika",
  "universitas": "Universitas Indonesia",
  "bidang_minat": "Oil & Gas",
  "no_hp": "081234567890",
  "alamat": "Jl. Example No. 1"
}
```

### Evaluasi API

**POST** `/api/simpan-evaluasi`
```json
{
  "pendaftar_id": 1,
  "nilai_kehadiran": 85,
  "nilai_kinerja": 80,
  "nilai_sikap": 90,
  "komentar": "Performa bagus..."
}
```

---

## 👥 Demo Account

| Role | Email | Password | Status |
|------|-------|----------|--------|
| Admin | admin@lemigas.ac.id | password | ✅ Active |
| Peserta 1 | siti@mahasiswa.ac.id | password123 | ✅ Active |
| Peserta 2 | budi@mahasiswa.ac.id | password456 | ✅ Active |

---

## 🔐 Security

- ✅ Password hashing dengan `password_hash()`
- ✅ SQL injection protection dengan prepared statements
- ✅ XSS protection
- ✅ CSRF token (optional)
- ✅ Secure session management
- ✅ Role-based access control

---

## 📊 Database Schema

### users table
```sql
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  nama VARCHAR(100),
  role ENUM('admin', 'pendaftar'),
  status ENUM('aktif', 'nonaktif'),
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### pendaftar table
```sql
CREATE TABLE pendaftar (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT UNIQUE,
  nim VARCHAR(20),
  jurusan VARCHAR(100),
  universitas VARCHAR(100),
  bidang_minat VARCHAR(100),
  no_hp VARCHAR(15),
  alamat TEXT,
  status ENUM('menunggu', 'diterima', 'ditolak', 'proses'),
  tanggal_daftar TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### evaluasi table
```sql
CREATE TABLE evaluasi (
  id INT PRIMARY KEY AUTO_INCREMENT,
  pendaftar_id INT UNIQUE,
  nilai_kehadiran INT,
  nilai_kinerja INT,
  nilai_sikap INT,
  rata_rata DECIMAL(5,2),
  status ENUM('belum', 'selesai'),
  komentar TEXT,
  tanggal_evaluasi TIMESTAMP,
  FOREIGN KEY (pendaftar_id) REFERENCES pendaftar(id)
);
```

---

## 🐛 Troubleshooting

### Database Connection Error
```
Error: "Koneksi Database Gagal"
Solusi: Pastikan MySQL running, cek config.php
```

### 404 Page Not Found
```
Error: "Halaman Tidak Ditemukan"
Solusi: Pastikan .htaccess ada, mod_rewrite enabled
```

### Permission Denied
```
Error: "Permission Denied"
Solusi: chmod -R 755 storage/
```

### Blank White Page
```
Error: White Screen of Death
Solusi: Set ENVIRONMENT='development' di config.php, cek error logs
```

**Lihat [SETUP.md](SETUP.md) untuk troubleshooting lengkap**

---

## 📝 License

MIT License - Bebas digunakan untuk keperluan komersial maupun non-komersial.

---

## 👨‍💻 Kontribusi

Kontribusi sangat diterima! Silakan:

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📞 Support & Contact

Untuk pertanyaan atau bantuan:

- 📧 Email: support@lemigas.ac.id
- 🐛 Report Issues: GitHub Issues
- 💬 Diskusi: GitHub Discussions

---

## 🎯 Roadmap

- [ ] Multi-bahasa (i18n)
- [ ] SMS notification
- [ ] Email notification
- [ ] Mobile app (React Native)
- [ ] Advanced analytics
- [ ] Certificate generation
- [ ] Integration dengan SIAKNG

---

## 📚 Additional Resources

- [Installation Guide](SETUP.md)
- [User Guide](docs/USER_GUIDE.md)
- [Developer Guide](docs/DEVELOPER_GUIDE.md)
- [API Documentation](docs/API.md)

---

## ⭐ Show Your Support

Jika project ini bermanfaat, berikan ⭐ di repository!

---

**Made with ❤️ for LEMIGAS**

*Terakhir diupdate: 2024*