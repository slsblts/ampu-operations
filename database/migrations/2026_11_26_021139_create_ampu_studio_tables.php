<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventori', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat');
            $table->string('kategori')->nullable();
            $table->integer('stok_total')->default(1);
            $table->integer('stok_tersedia')->default(1);
            $table->string('kondisi')->default('Baik');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peminjam');
            $table->string('nim_nik');
            $table->string('no_hp');
            $table->string('organisasi');
            $table->string('keperluan');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            $table->string('kondisi_kembali')->nullable();
            $table->text('catatan_kembali')->nullable();
            $table->foreignId('admin_pinjam_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('admin_kembali_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->cascadeOnDelete();
            $table->foreignId('inventori_id')->nullable()->constrained('inventori')->nullOnDelete();
            $table->string('nama_barang');
            $table->integer('jumlah')->default(1);
            $table->timestamps();
        });

        Schema::create('jadwal_studio', function (Blueprint $table) {
            $table->id();
            $table->string('nama_studio');
            $table->string('nama_acara');
            $table->string('pic_kru');
            $table->date('tanggal_booking');
            $table->string('sesi_jam');
            $table->enum('status', ['terjadwal', 'dikonfirmasi', 'selesai', 'dibatalkan'])->default('dikonfirmasi');
            $table->foreignId('admin_pembuat_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_studio');
        Schema::dropIfExists('detail_peminjaman');
        Schema::dropIfExists('peminjaman');
        Schema::dropIfExists('inventori');
    }
};