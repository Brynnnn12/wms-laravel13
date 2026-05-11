# Sistem Inventory

Sistem manajemen inventaris berbasis web yang dirancang untuk mengelola barang-barang, stok, penyusutan, dan operasi terkait inventaris dengan efisien. Aplikasi ini dibangun menggunakan Laravel 13 dengan antarmuka modern menggunakan Tailwind CSS dan Alpine.js.

## 🚀 Fitur Utama

- **Manajemen Barang**: Tambah, edit, hapus, dan pantau barang inventaris
- **Klasifikasi Barang**: Kategori jenis barang, status, kondisi, dan lokasi penyimpanan
- **Stok Opname**: Lakukan inventarisasi berkala untuk memverifikasi stok
- **Penyusutan Aset**: Hitung dan kelola penyusutan nilai barang secara otomatis
- **Penyesuaian Stok**: Sesuaikan jumlah stok berdasarkan kebutuhan
- **Manajemen Pengguna**: Sistem role dan permission dengan Spatie Laravel Permission
- **Authentication**: Login dengan email/password dan Google OAuth
- **Laporan & Ekspor**: Ekspor data ke Excel dan generate PDF
- **Dashboard Analytics**: Visualisasi data dengan Chart.js
- **QR Code**: Generate QR code untuk identifikasi barang
- **Notifikasi**: Sweet Alert untuk feedback pengguna

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 13**: Framework PHP modern dengan fitur terkini
- **PHP 8.3+**: Versi PHP terbaru untuk performa optimal
- **MySQL/PostgreSQL**: Database relasional
- **Spatie Laravel Permission**: Manajemen role dan permission
- **Laravel Socialite**: Authentication dengan Google
- **DomPDF**: Generate PDF reports
- **Maatwebsite Excel**: Import/ekspor data Excel
- **Simple QR Code**: Generate QR code

### Frontend
- **Tailwind CSS**: Framework CSS utility-first
- **Alpine.js**: Framework JavaScript reaktif minimal
- **Vite**: Build tool modern dan cepat
- **Chart.js**: Library visualisasi data
- **Tom Select**: Enhanced select dropdowns
- **Axios**: HTTP client untuk AJAX requests

### Development Tools
- **Pest**: Framework testing modern
- **Laravel Pint**: Code style fixer
- **Laravel Pail**: Enhanced logging
- **Composer**: Dependency management PHP
- **NPM**: Dependency management JavaScript

## 📋 Persyaratan Sistem

- **PHP**: 8.3 atau lebih tinggi
- **Composer**: 2.0+
- **Node.js**: 18.0+ dengan NPM
- **Database**: MySQL 8.0+ atau PostgreSQL 13+
- **Web Server**: Apache/Nginx dengan mod_rewrite
- **Memory**: Minimal 512MB RAM
- **Storage**: 100MB+ untuk aplikasi dan data

## 🔧 Instalasi dan Pemasangan

### Langkah 1: Clone Repository

```bash
git clone https://github.com/Brynnnn12/wms-laravel13.git
cd wms-laravel13
```

### Langkah 2: Install Dependencies PHP

```bash
composer install
```

### Langkah 3: Install Dependencies JavaScript

```bash
npm install
```

### Langkah 4: Konfigurasi Environment

1. Salin file environment:
```bash
cp .env.example .env
```

2. Edit file `.env` dengan konfigurasi database dan aplikasi:
```env
APP_NAME="Sistem Inventory"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_inventory
DB_USERNAME=root
DB_PASSWORD=

# Google OAuth (opsional)
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret

# Mail Configuration (opsional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Langkah 5: Generate Application Key

```bash
php artisan key:generate
```

### Langkah 6: Setup Database

1. Buat database baru di MySQL/PostgreSQL dengan nama `sistem_inventory`

2. Jalankan migrasi database:
```bash
php artisan migrate
```

3. (Opsional) Jalankan seeder untuk data awal:
```bash
php artisan db:seed
```

### Langkah 7: Setup Permissions

Jalankan command untuk setup role dan permission default:

```bash
php artisan permission:create-role admin
php artisan permission:create-role user
```

### Langkah 8: Build Assets Frontend

```bash
npm run build
```

Atau untuk development dengan hot reload:

```bash
npm run dev
```

### Langkah 9: Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 🧪 Testing

Jalankan test suite menggunakan Pest:

```bash
php artisan test
```

Untuk test spesifik:

```bash
php artisan test tests/Feature/JenisBarang/JenisBarangTest.php
```

## 📊 Struktur Database

Aplikasi ini menggunakan database dengan tabel utama:

- `users`: Data pengguna dan authentication
- `permissions` & `roles`: Sistem permission dengan Spatie
- `jenis_barangs`: Kategori jenis barang
- `status_barangs`: Status kondisi barang
- `kondisi_barangs`: Tingkat kondisi barang
- `lokasi_penyimpanans`: Lokasi penyimpanan
- `nama_ruangs`: Nama ruangan
- `barangs`: Data barang inventaris
- `stok_opnames`: Record stok opname
- `penyesuaians`: Record penyesuaian stok
- `penyusutans`: Record penyusutan aset

## 🚀 Deployment

### Production Setup

1. Pastikan semua dependencies terinstall
2. Set `APP_ENV=production` di `.env`
3. Set `APP_DEBUG=false`
4. Konfigurasi web server (Apache/Nginx)
5. Setup SSL certificate
6. Jalankan `php artisan config:cache`
7. Jalankan `php artisan route:cache`
8. Jalankan `php artisan view:cache`
9. Setup queue worker jika diperlukan

### Environment Variables Production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
DB_CONNECTION=mysql
DB_HOST=your_db_host
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

## 🤝 Kontribusi

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 Lisensi

Proyek ini menggunakan lisensi MIT. Lihat file `LICENSE` untuk detail lebih lanjut.

## 📞 Dukungan

Jika Anda mengalami masalah atau memiliki pertanyaan:

1. Periksa dokumentasi Laravel di [laravel.com/docs](https://laravel.com/docs)
2. Lihat issues di GitHub repository
3. Buat issue baru jika belum ada yang serupa

## 🙏 Acknowledgments

- [Laravel](https://laravel.com/) - Framework PHP yang powerful
- [Tailwind CSS](https://tailwindcss.com/) - Utility-first CSS framework
- [Alpine.js](https://alpinejs.dev/) - Minimal reactive framework
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) - Package permission management
- Semua kontributor open source yang membuat teknologi ini mungkin

---

**Dibuat dengan ❤️ menggunakan Laravel 13**