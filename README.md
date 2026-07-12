# Sistem Informasi Pemesanan Tiket Wisata Online

Sistem Informasi Pemesanan Tiket Wisata Online merupakan aplikasi berbasis web yang digunakan untuk mengelola destinasi wisata, pemesanan tiket, transaksi, serta validasi pembayaran secara terintegrasi.

Project ini dikembangkan oleh **Jalcode Digital Solutions** menggunakan Laravel sebagai framework utama dengan Filament sebagai admin panel.

---

# Tech Stack

| Teknologi      | Versi                  |
| -------------- | ---------------------- |
| Framework      | Laravel 13             |
| Architecture   | Monolith               |
| Admin Panel    | Filament v3            |
| Frontend       | Laravel Blade          |
| Styling        | Tailwind CSS v4        |
| Database       | MySQL                  |
| Authentication | Laravel Authentication |
| Permission     | Spatie Permission      |
| Media Upload   | Spatie MediaLibrary    |
| Export Excel   | Laravel Excel          |
| PDF Generator  | domPDF                 |

---

# 💻 Requirements

Pastikan perangkat telah terpasang:

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL
- Git
- Laragon / XAMPP (Opsional)

---

# Instalasi Project

## 1. Clone Repository

```bash
git clone https://github.com/username/tiket-wisata.git
cd tiket-wisata
```

> Ganti URL repository sesuai repository GitHub project.

---

## 2. Install Dependency

### Backend

```bash
composer install
```

### Frontend

```bash
npm install
```

---

## 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`

```bash
cp .env.example .env
```

atau pada Windows

```bash
copy .env.example .env
```

Lalu sesuaikan konfigurasi database.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tiket_wisata
DB_USERNAME=root
DB_PASSWORD=
```

Pastikan database **tiket_wisata** sudah dibuat terlebih dahulu.

---

## 4. Generate Application Key

```bash
php artisan key:generate
```

---

## 5. Jalankan Migration

```bash
php artisan migrate
```

Jika project memiliki seeder:

```bash
php artisan db:seed
```

atau

```bash
php artisan migrate --seed
```

---

## 6. Storage Link

Karena aplikasi menggunakan upload gambar dan file, jalankan:

```bash
php artisan storage:link
```

---

## 7. Membuat Super Admin

Buat akun pertama untuk login ke Filament.

```bash
php artisan make:filament-user
```

Masukkan:

- Nama
- Email
- Password

---

# Menjalankan Project

Project membutuhkan dua terminal.

## Terminal 1

Menjalankan Laravel.

```bash
php artisan serve
```

Akses:

Frontend

```
http://localhost:8000
```

Admin Panel

```
http://localhost:8000/admin
```

---

## Terminal 2

Menjalankan Vite.

```bash
npm run dev
```

---

# Struktur Folder Frontend

```
resources/
└── views/
    ├── components/
    │   ├── ui/
    │   ├── blocks/
    │   └── sections/
    │
    ├── layouts/
    │
    └── pages/
```

### components/ui

Komponen dasar.

Contoh:

- Button
- Input
- Badge
- Modal
- Label

---

### components/blocks

Gabungan beberapa komponen UI.

Contoh:

- Card
- Search Form
- Login Form
- Ticket Card

---

### components/sections

Bagian besar halaman.

Contoh:

- Navbar
- Hero
- Footer
- CTA
- Gallery

---

### layouts

Template utama halaman.

Contoh:

```
app.blade.php
```

---

### pages

Halaman yang diakses user.

Contoh:

- Home
- Destinasi
- Detail Wisata
- Checkout
- Riwayat Tiket

---

# Git Workflow (Jalcode SOP)

## Jangan Push Langsung ke `main`

Branch `main` hanya dikelola oleh **Tech Lead**.

---

## Selalu Membuat Branch Baru

Gunakan format:

```bash
feature/nama-fitur
```

Contoh:

```bash
feature/admin-pengelola
```

```bash
feature/front-katalog-wisata
```

```bash
feature/transaksi
```

---

## Setelah Selesai

Commit perubahan.

```bash
git add .
git commit -m "feat: menambahkan halaman katalog wisata"
```

Push branch.

```bash
git push origin feature/front-katalog-wisata
```

Kemudian buat **Pull Request (PR)** ke branch `main` untuk direview oleh Tech Lead.

---

## Selalu Update Branch

Sebelum mulai bekerja:

```bash
git checkout main
git pull origin main
```

Kemudian kembali ke branch feature.

```bash
git checkout feature/nama-fitur
git merge main
```

atau menggunakan rebase sesuai SOP tim.

---

# Build Production

Install dependency production.

```bash
composer install --optimize-autoloader --no-dev
```

Compile asset.

```bash
npm run build
```

Cache konfigurasi.

```bash
php artisan optimize
```

---

# Lisensi

Project ini merupakan bagian dari pengembangan internal **Jalcode Digital Solutions**.

Hak cipta © 2026 Jalcode. Seluruh hak dilindungi.
