# AMPU OPERATIONS — Studio Gear Logbook & Room Scheduling System

Aplikasi web internal berbasis *mobile-first* yang dikembangkan untuk mendigitalisasi pencatatan operasional harian peminjaman peralatan produksi dan penjadwalan ruang studio di **Ampu Studio**.

## Fitur Utama
- **Logbook Peminjaman Alat Dinamis:** Pencatatan transaksi peminjaman berbasis *free-text* untuk mengakomodasi beragam aksesori produksi, lengkap dengan pencatatan identitas peminjam dan admin piket yang menyerahkan alat.
- **Verifikasi Pengembalian Barang:** Konfirmasi pengembalian peralatan dengan pencatatan kondisi fisik barang, catatan kelengkapan, dan admin penerima.
- **Penjadwalan Ruang Studio Real-Time:** Manajemen reservasi sesi penggunaan Studio 1 dan Studio 2 berdasarkan proyek, kru PIC, serta pembaruan status sesi (`confirmed`, `completed`, `cancelled`).
- **Arsip Riwayat Multi-Tab & Export CSV:** Rekapitulasi terpisah untuk riwayat pengembalian alat dan pemakaian studio dengan fitur pencarian kata kunci, filter rentang waktu, serta unduhan laporan dalam format CSV.

## Tech Stack
- **Backend:** Laravel, PHP
- **Database:** MySQL
- **Frontend:** Blade Template, Tailwind CSS

## Struktur Tabel Database
- `users`: Akun admin dan kru piket operasional studio.
- `loans`: Data transaksi peminjaman, tanggal pinjam/kembali, status, dan kondisi pengembalian.
- `loan_items`: Rincian daftar barang dan kuantitas per transaksi peminjaman.
- `studio_bookings`: Jadwal dan riwayat sesi pemakaian Studio 1 & Studio 2.

## Instalasi Lokal
1. Clone repository ini:
   ```bash
   git clone [https://github.com/slsblts/ampu-operations.git](https://github.com/slsblts/ampu-operations.git)
   cd ampu-operations