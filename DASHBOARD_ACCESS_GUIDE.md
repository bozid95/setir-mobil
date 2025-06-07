# 🚗 Dashboard Access Guide

## 🌐 Cara Mengakses Dashboard

Aplikasi driving school ini memiliki 2 dashboard yang berbeda:

### 1. 📋 Admin Dashboard (Filament)

**URL**: `http://localhost:8000/admin`

**Login Credentials**:

-   **Email**: `admin@admin.com`
-   **Password**: `password`

**Fitur**:

-   Manajemen lengkap data driving school
-   CRUD untuk Students, Instructors, Packages, Sessions, Materials, Finances
-   Dashboard dengan widgets statistik
-   Relation managers untuk data yang terhubung

### 2. 🏠 Landing Page & Student Dashboard (Public)

**Landing Page**: `http://localhost:8000/`
**Student Dashboard**: `http://localhost:8000/student/{unique_code}`

**Fitur**:

-   Registration form untuk student baru
-   Tracking progress dengan unique code
-   Dashboard student tanpa perlu login
-   Informasi pembayaran dan jadwal

---

## 🚀 Cara Menjalankan Aplikasi

1. **Start development server**:

```bash
cd d:\rental-mobil\rental-mobil
php artisan serve
```

2. **Buka browser dan akses**:
    - **Admin**: http://localhost:8000/admin
    - **Landing**: http://localhost:8000/

---

## 👥 Test Account

### Admin Login

-   Email: `admin@admin.com`
-   Password: `password`

### Student Testing

1. Daftar melalui landing page untuk mendapatkan unique code
2. Atau gunakan unique code yang sudah ada dari seeder

---

## 🔧 Troubleshooting

### Jika admin dashboard tidak bisa diakses:

1. Pastikan AdminUserSeeder sudah dijalankan:

```bash
php artisan db:seed --class=AdminUserSeeder
```

2. Check path Filament di `AdminPanelProvider.php`:

```php
->path('admin')  // Harus 'admin', bukan ''
```

### Jika landing page tidak muncul:

1. Check routes di `routes/web.php`
2. Pastikan controller `LandingController` ada
3. Pastikan views di `resources/views/landing/` ada

---

## 📱 Fitur Dashboard

### Admin Dashboard:

-   ✅ Stats Overview Widget
-   ✅ Student Registrations Chart
-   ✅ Revenue Chart
-   ✅ Latest Students Widget
-   ✅ Upcoming Sessions Widget
-   ✅ Complete CRUD for all models
-   ✅ Relation managers

### Student Dashboard:

-   ✅ Personal information display
-   ✅ Package information
-   ✅ Learning progress bar
-   ✅ Sessions history
-   ✅ Payment status
-   ✅ Instructor information
-   ✅ Unique code tracking

---

## 🎯 Next Steps

1. **Test Registration Flow**:

    - Buka http://localhost:8000/
    - Daftar sebagai student baru
    - Catat unique code yang diberikan
    - Test tracking dengan unique code

2. **Test Admin Features**:

    - Login ke admin dashboard
    - Explore semua resources
    - Test CRUD operations
    - Check widgets functionality

3. **Customize**:
    - Sesuaikan tampilan sesuai brand
    - Tambah validasi tambahan
    - Konfigurasi email notifications
    - Setup payment integration
