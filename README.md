# Laravel 13 Boilerplate - Template Sistem Absensi

> Boilerplate Laravel 13 siap pakai dengan authentication Breeze, role-based permission menggunakan Spatie Laravel Permission, dan struktur dasar untuk membangun sistem absensi karyawan.

## 🎯 DESKRIPSI PROYEK

Proyek ini adalah **Laravel 13 Boilerplate** yang menyediakan fondasi lengkap untuk membangun sistem absensi karyawan. Template ini sudah dikonfigurasi dengan komponen-komponen essential:

- ✅ **Authentication siap pakai** dengan Laravel Breeze
- ✅ **Role & Permission system** menggunakan Spatie Laravel Permission
- ✅ **Struktur database** untuk sistem absensi (users, employees, attendances)
- ✅ **UI responsive** dengan Tailwind CSS dan split-screen design
- ✅ **Migrations & seeders** siap pakai

## 📦 APA YANG SUDAH TERSEDIA

### Authentication & Authorization
- Login/Register dengan Laravel Breeze
- Role-based access control (Admin & Employee)
- Permission management dengan Spatie

### Struktur Database
- Tabel `users` (Laravel Breeze) untuk authentication
- Tabel `employees` untuk data karyawan
- Tabel `attendances` untuk catatan absensi
- Migrations dan seeders siap pakai

### UI Components
- Layout responsive dengan split-screen design
- Dashboard admin dan employee (struktur dasar)
- Form authentication yang sudah styled
- Template Blade dengan Tailwind CSS

## 📊 STRUKTUR DATABASE (3 Tabel)

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│    employees    │────▶│   attendances   │     │     users       │
├─────────────────┤     ├─────────────────┤     ├─────────────────┤
│ id (PK)         │     │ id (PK)         │     │ id (PK)         │
│ nik (unique)    │     │ employee_id(FK) │     │ name            │
│ name            │     │ date            │     │ email           │
│ email (unique)  │     │ check_in        │     │ password        │
│ phone           │     │ check_out       │     │ employee_id(FK) │
│ is_active       │     │ status          │     └─────────────────┘
└─────────────────┘     └─────────────────┘
```

**Relasi Database:**
- `employees (1) → attendances (M)`: Satu karyawan dapat memiliki banyak catatan absensi
- `users (1) → employees (1)`: Satu akun user terhubung dengan satu data karyawan

## 👥 ROLE & PERMISSION SYSTEM

| Role     | Akses & Permissions |
|----------|-------------------|
| **Admin** | • Melihat semua data absensi karyawan<br>• Mengedit data absensi (jam masuk/keluar, status)<br>• Mengelola data karyawan<br>• Melihat laporan dan statistik keseluruhan<br>• Filter dan export data absensi |
| **Employee** | • Check-in dan check-out mandiri<br>• Melihat riwayat absensi pribadi<br>• Melihat statistik kehadiran bulanan<br>• Update profil karyawan |

## 🔄 ALUR BISNIS YANG BISA DIIMPLEMENTASIKAN

### 1. Authentication & Authorization
```
User Login → Validasi Credentials → Cek Role → Redirect ke Dashboard Sesuai Role
```

### 2. Check-In Process (Absen Masuk)
```
Karyawan klik "Check In"
    ↓
Validasi: Belum absen hari ini?
    ↓
Jika Valid → Catat timestamp check-in
    ↓
Status Otomatis:
• ≤ 08:00 → "Present" (Tepat Waktu)
• > 08:00 → "Late" (Terlambat)
```

### 3. Check-Out Process (Absen Pulang)
```
Karyawan klik "Check Out"
    ↓
Validasi: Sudah check-in hari ini?
    ↓
Jika Valid → Catat timestamp check-out
    ↓
Hitung total jam kerja otomatis
```

### 4. Reporting & Analytics
```
Admin → Dashboard dengan metrics keseluruhan
Employee → Dashboard dengan metrics pribadi
```

## 📱 FITUR YANG BISA DIKEMBANGKAN

### 👨‍💼 Dashboard Administrator:
- 📊 **Real-time Statistics**: Total karyawan aktif, kehadiran harian, absensi bulanan
- 📋 **Attendance Management**: View, edit, filter riwayat absensi semua karyawan
- 👥 **Employee Management**: Daftar karyawan dengan status aktif/non-aktif
- 📈 **Advanced Reporting**: Filter berdasarkan tanggal, karyawan, status
- 📤 **Data Export**: Export laporan ke Excel untuk analisis lanjutan

### 👤 Dashboard Karyawan:
- 🕐 **Quick Attendance**: Check-in/check-out dengan satu klik
- 📊 **Personal Statistics**: Ringkasan kehadiran bulan berjalan
- 📅 **Attendance History**: Riwayat absensi 30 hari terakhir
- 👤 **Profile Management**: Update informasi pribadi

## 📊 STRUKTUR DATABASE (3 Tabel)

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│    employees    │────▶│   attendances   │     │     users       │
├─────────────────┤     ├─────────────────┤     ├─────────────────┤
│ id (PK)         │     │ id (PK)         │     │ id (PK)         │
│ nik (unique)    │     │ employee_id(FK) │     │ name            │
│ name            │     │ date            │     │ email           │
│ email (unique)  │     │ check_in        │     │ password        │
│ phone           │     │ check_out       │     │ employee_id(FK) │
│ is_active       │     │ status          │     └─────────────────┘
└─────────────────┘     └─────────────────┘
```

**Relasi Database:**
- `employees (1) → attendances (M)`: Satu karyawan dapat memiliki banyak catatan absensi
- `users (1) → employees (1)`: Satu akun user terhubung dengan satu data karyawan

## 👥 ROLE & PERMISSION SYSTEM

| Role     | Akses & Permissions |
|----------|-------------------|
| **Admin** | • Melihat semua data absensi karyawan<br>• Mengedit data absensi (jam masuk/keluar, status)<br>• Mengelola data karyawan<br>• Melihat laporan dan statistik keseluruhan<br>• Filter dan export data absensi |
| **Employee** | • Check-in dan check-out mandiri<br>• Melihat riwayat absensi pribadi<br>• Melihat statistik kehadiran bulanan<br>• Update profil karyawan |

## 🔄 ALUR BISNIS SISTEM

### 1. Authentication & Authorization
```
User Login → Validasi Credentials → Cek Role → Redirect ke Dashboard Sesuai Role
```

### 2. Check-In Process (Absen Masuk)
```
Karyawan klik "Check In"
    ↓
Validasi: Belum absen hari ini?
    ↓
Jika Valid → Catat timestamp check-in
    ↓
Status Otomatis:
• ≤ 08:00 → "Present" (Tepat Waktu)
• > 08:00 → "Late" (Terlambat)
```

### 3. Check-Out Process (Absen Pulang)
```
Karyawan klik "Check Out"
    ↓
Validasi: Sudah check-in hari ini?
    ↓
Jika Valid → Catat timestamp check-out
    ↓
Hitung total jam kerja otomatis
```

### 4. Reporting & Analytics
```
Admin → Dashboard dengan metrics keseluruhan
Employee → Dashboard dengan metrics pribadi
```

## 📱 FITUR UTAMA

### 👨‍💼 Dashboard Administrator:
- 📊 **Real-time Statistics**: Total karyawan aktif, kehadiran harian, absensi bulanan
- 📋 **Attendance Management**: View, edit, filter riwayat absensi semua karyawan
- 👥 **Employee Management**: Daftar karyawan dengan status aktif/non-aktif
- 📈 **Advanced Reporting**: Filter berdasarkan tanggal, karyawan, status
- 📤 **Data Export**: Export laporan ke Excel untuk analisis lanjutan

### 👤 Dashboard Karyawan:
- 🕐 **Quick Attendance**: Check-in/check-out dengan satu klik
- 📊 **Personal Statistics**: Ringkasan kehadiran bulan berjalan
- 📅 **Attendance History**: Riwayat absensi 30 hari terakhir
- 👤 **Profile Management**: Update informasi pribadi

## 🗂️ ARSITEKTUR APLIKASI

```
app/
├── Models/
│   ├── User.php              # User model with Spatie Permission
│   ├── Employee.php          # Employee data model
│   └── Attendance.php        # Attendance records model
├── Http/Controllers/
│   ├── DashboardController.php    # Main dashboard logic
│   ├── AttendanceController.php   # Attendance CRUD operations
│   ├── EmployeeController.php     # Employee management
│   └── Auth/                      # Authentication controllers
├── Policies/                      # Authorization policies
│   ├── AttendancePolicy.php
│   └── EmployeePolicy.php
└── database/
    ├── migrations/               # Database schema migrations
    └── seeders/                 # Database seeding files

resources/
└── views/
    ├── layouts/
    │   └── app.blade.php        # Main application layout
    ├── dashboard/
    │   ├── admin.blade.php      # Admin dashboard
    │   └── employee.blade.php   # Employee dashboard
    ├── attendances/             # Attendance management views
    └── employees/               # Employee management views
```

## � INSTALASI & SETUP BOILERPLATE

### Prerequisites:
- PHP 8.3 atau lebih tinggi
- Composer
- MySQL 8.0+
- Node.js & NPM

### Quick Start:
```bash
# 1. Clone atau download boilerplate ini
git clone <repository-url>
cd laravel-13-boilerplate

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_boilerplate
DB_USERNAME=your_username
DB_PASSWORD=your_password

# 5. Setup database
php artisan migrate
php artisan db:seed

# 6. Build assets
npm run build

# 7. Jalankan server
php artisan serve
```

### Akun Default untuk Testing:
| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@admin.com` | `password` |
| **Employee** | `budi@email.com` | `password` |

## 📖 CARA MENGGUNAKAN BOILERPLATE INI

### 1. Setup Awal
- Clone repository ini
- Ikuti langkah instalasi di atas
- Akses `http://localhost:8000` untuk melihat halaman login

### 2. Struktur Kode yang Sudah Ada
- **Authentication**: Login/register sudah siap dengan Breeze
- **Database**: Tabel users, employees, attendances sudah dibuat
- **Roles**: Admin dan Employee role sudah dikonfigurasi
- **UI**: Layout dasar dengan Tailwind CSS sudah ada

### 3. Pengembangan Fitur Absensi
Untuk mengimplementasikan fitur absensi lengkap, Anda perlu mengembangkan:

#### Check-in/Check-out Logic:
```php
// Di AttendanceController
public function checkIn(Request $request)
{
    // Logika check-in karyawan
    // Validasi belum absen hari ini
    // Simpan timestamp check-in
    // Tentukan status (present/late)
}

public function checkOut(Request $request)
{
    // Logika check-out karyawan
    // Validasi sudah check-in hari ini
    // Simpan timestamp check-out
    // Hitung total jam kerja
}
```

#### Dashboard Admin:
- Buat controller untuk menampilkan statistik
- Implementasikan view untuk mengelola karyawan
- Tambahkan fitur export data

#### Dashboard Employee:
- Buat view untuk check-in/check-out
- Implementasikan riwayat absensi pribadi
- Tambahkan statistik kehadiran

### 4. Development Workflow
```bash
# Jalankan server development
php artisan serve

# Compile assets untuk development
npm run dev

# Jalankan test
php artisan test

# Buat model/controller baru
php artisan make:model Attendance -mc
php artisan make:controller AttendanceController
```

### 5. Fitur Tambahan yang Bisa Dikembangkan
- **Real-time Attendance**: AJAX untuk check-in/check-out tanpa reload
- **QR Code**: Generate QR untuk absensi mobile
- **Location Tracking**: Validasi lokasi absensi
- **Face Recognition**: Integrasi dengan face recognition API
- **Notification**: Email/SMS reminder absensi
- **Mobile App**: API untuk aplikasi mobile
- **Advanced Reporting**: Dashboard dengan charts dan analytics

## 🔧 TEKNOLOGI YANG DIGUNAKAN

- **Laravel 13** - Framework PHP modern
- **Laravel Breeze** - Authentication siap pakai
- **Spatie Laravel Permission** - Role & permission management
- **Tailwind CSS** - Utility-first CSS framework
- **MySQL** - Database relasional
- **Vite** - Asset bundler untuk development

## 📁 STRUKTUR PROYEK

```
app/
├── Models/ (User, Employee, Attendance - struktur dasar)
├── Http/Controllers/ (Dashboard, Attendance, Employee - perlu dikembangkan)
├── Policies/ (Authorization policies - dasar sudah ada)
database/
├── migrations/ (Database schema - sudah lengkap)
├── seeders/ (Data awal - sudah ada)
resources/
├── views/ (Blade templates dengan Tailwind - struktur dasar)
├── css/ & js/ (Frontend assets - dasar sudah ada)
routes/
├── web.php (Routing aplikasi - dasar sudah ada)
```


## 🎯 KELEBIHAN BOILERPLATE INI

- ✅ **Fondasi Solid**: Struktur Laravel yang sudah terorganisir
- ✅ **Authentication Ready**: Breeze sudah terintegrasi
- ✅ **Role System**: Spatie Permission sudah dikonfigurasi
- ✅ **Database Schema**: Struktur tabel absensi lengkap
- ✅ **UI Foundation**: Tailwind CSS dengan design system
- ✅ **Extensible**: Mudah dikembangkan sesuai kebutuhan
- ✅ **Production Ready**: Struktur yang siap untuk production

## 📋 ROADMAP PENGEMBANGAN

### Phase 1: Core Attendance Features
- [ ] Implementasi check-in/check-out logic
- [ ] Dashboard admin dengan statistik dasar
- [ ] Dashboard employee untuk absensi pribadi
- [ ] Validasi business rules (duplicate check-in, etc.)

### Phase 2: Advanced Features
- [ ] Real-time attendance dengan AJAX
- [ ] Export laporan ke Excel/PDF
- [ ] Advanced filtering dan search
- [ ] Email notifications

### Phase 3: Additional Modules
- [ ] Leave management system
- [ ] Overtime tracking
- [ ] Performance analytics
- [ ] Mobile API development

---

## 👨‍💻 Author

**brynnnn12**

*Laravel Developer specializing in business applications boilerplates.*

## 📄 License

MIT License - use this boilerplate for your projects!
