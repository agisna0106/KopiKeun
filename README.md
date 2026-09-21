# Sistem Informasi Operasional Kopi Keliling Kopikeun

Sistem informasi berbasis web untuk mendukung pengelolaan operasional
**Kopi Keliling Kopikeun**. Aplikasi dirancang dengan pendekatan
**mobile-first** agar nyaman digunakan melalui perangkat mobile maupun
desktop.

## Fitur Utama

-   Authentication dan hak akses berbasis role
-   Dashboard
-   Pengelolaan produk
-   Pencatatan stok bahan baku
-   Pencatatan barang masuk
-   Pencatatan pengeluaran operasional
-   Transaksi penjualan
-   Distribusi produk jadi kepada karyawan
-   Pencatatan sisa produk
-   Pengelolaan karyawan
-   Laporan keuangan

## Role Pengguna

### Owner

-   Melihat dashboard
-   Mengelola produk
-   Melakukan transaksi penjualan
-   Mengelola karyawan
-   Melihat laporan keuangan

### Admin

-   Melihat dashboard
-   Mengelola produk
-   Mencatat stok bahan baku
-   Mencatat barang masuk
-   Mencatat pengeluaran operasional
-   Melakukan transaksi penjualan
-   Mencatat distribusi produk
-   Mencatat sisa produk

### Karyawan

-   Login
-   Melihat dashboard
-   Melakukan transaksi penjualan

## Modul

### Produk

CRUD data produk.

### Stok Bahan Baku

Mencatat kondisi stok berdasarkan hasil pengecekan stok.

### Barang Masuk

Mencatat bahan baku yang diterima atau dibeli.

-   Jika bahan sudah ada, jumlah masuk ditambahkan ke stok.
-   Jika bahan belum ada, sistem membuat data bahan baru dengan stok
    awal sebesar jumlah masuk.
-   Setiap barang masuk tetap disimpan sebagai riwayat.
-   Harga pembelian dicatat untuk kebutuhan laporan keuangan.

### Pengeluaran Operasional

Mencatat pengeluaran seperti bensin, gas, kemasan, dan biaya operasional
lainnya.

Data minimal: - Jenis pengeluaran - Jumlah - Tanggal - Keterangan

### Transaksi Penjualan

Alur utama: 1. Memilih produk 2. Memasukkan jumlah 3. Sistem menghitung
subtotal dan total 4. Memilih metode pembayaran 5. Menyimpan transaksi

Metode pembayaran: - Cash - QRIS

### Distribusi Produk

Admin mencatat produk jadi yang diberikan kepada karyawan untuk dibawa
ke gerobak.

### Sisa Produk

Admin mencatat produk yang masih tersisa ketika karyawan kembali. Data
distribusi tidak diubah; sisa dicatat sebagai data tersendiri.

### Pengelolaan Karyawan

Owner mengelola data karyawan.

### Laporan Keuangan

Owner melihat laporan berdasarkan periode tertentu.

Sumber data: - Pemasukan dari transaksi penjualan - Pengeluaran
pembelian bahan baku dari barang masuk - Pengeluaran operasional

Rumus:

``` text
Total Pengeluaran =
Total Pembelian Bahan Baku + Total Pengeluaran Operasional

Keuntungan =
Total Pemasukan - Total Pengeluaran
```

## Teknologi

-   PHP 8.3
-   Laravel
-   Laravel Breeze
-   Tailwind CSS
-   Vite
-   MySQL
-   Git & GitHub

> Versi Laravel dan dependency mengikuti versi yang terpasang pada
> project.

## UI/UX

Aplikasi menggunakan pendekatan **mobile-first**.

Prinsip: - Desain dimulai dari layar mobile. - Layout responsif untuk
tablet dan desktop. - Navigasi sederhana. - Form nyaman digunakan pada
layar sentuh. - Informasi penting mudah dipindai. - Komponen UI
konsisten.

## Arsitektur

``` text
User
  ↓
View
  ↓
Controller
  ↓
Model
  ↓
Database
```

## Alur Pengembangan

``` text
Requirement
    ↓
Use Case
    ↓
Activity Diagram
    ↓
Sequence Diagram
    ↓
Implementasi
    ↓
Database
    ↓
Testing
    ↓
Finalisasi ERD & Class Diagram
```

## Instalasi

### 1. Clone repository

``` bash
git clone <repository-url>
cd <nama-project>
```

### 2. Install dependency

``` bash
composer install
npm install
```

### 3. Buat environment

``` bash
cp .env.example .env
```

Windows PowerShell:

``` powershell
Copy-Item .env.example .env
```

### 4. Generate key

``` bash
php artisan key:generate
```

### 5. Konfigurasi database

Edit `.env`:

``` env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kopikeun
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Migration

``` bash
php artisan migrate
```

Jika tersedia seeder:

``` bash
php artisan db:seed
```

### 7. Jalankan aplikasi

Terminal 1:

``` bash
php artisan serve
```

Terminal 2:

``` bash
npm run dev
```

Buka:

``` text
http://127.0.0.1:8000
```

## Git Workflow

Jangan push langsung ke branch utama.

``` text
Pull
 ↓
Buat branch fitur
 ↓
Coding
 ↓
Testing
 ↓
Commit
 ↓
Push
 ↓
Pull Request
 ↓
Merge
```

Contoh:

``` bash
git pull origin main
git checkout -b feature/nama-fitur
```

Penamaan branch:

``` text
feature/nama-fitur
fix/nama-masalah
refactor/nama-perubahan
```

## Status Pengembangan

-   [x] Analisis kebutuhan
-   [x] Use Case
-   [x] Activity Diagram
-   [x] Sequence Diagram
-   [ ] Setup project final
-   [ ] Authentication & role
-   [ ] Database implementation
-   [ ] Produk
-   [ ] Bahan baku
-   [ ] Barang masuk
-   [ ] Pengeluaran operasional
-   [ ] Transaksi penjualan
-   [ ] Distribusi produk
-   [ ] Sisa produk
-   [ ] Pengelolaan karyawan
-   [ ] Laporan keuangan
-   [ ] Dashboard
-   [ ] Testing
-   [ ] ERD final
-   [ ] Class Diagram final
-   [ ] Deployment

## Catatan

Project ini dikembangkan sebagai bagian dari **Kerja Praktik (KP)**
dengan studi kasus **Kopi Keliling Kopikeun**.

Dokumentasi teknis akan diperbarui mengikuti perkembangan implementasi
aplikasi.
