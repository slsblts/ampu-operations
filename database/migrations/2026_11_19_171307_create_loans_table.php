<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('borrower_name');
            $table->string('borrower_id_number'); // NIM / NIK
            $table->string('phone_number');
            $table->string('organization'); // Organisasi / Divisi
            $table->string('purpose'); // Keperluan / Acara
            $table->date('borrow_date');
            $table->date('return_date')->nullable();
            $table->enum('status', ['borrowed', 'returned'])->default('borrowed');
            $table->string('return_condition')->nullable(); // Lengkap & Normal, Perlu Cek, Kurang/Rusak
            $table->text('return_notes')->nullable();
            $table->foreignId('issued_by_admin_id')->constrained('users');
            $table->foreignId('received_by_admin_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};