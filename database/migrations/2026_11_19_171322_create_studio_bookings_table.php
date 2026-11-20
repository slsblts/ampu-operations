<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('studio_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('studio_name'); // Studio 1 - Podcast / Studio 2 - Utama
            $table->string('project_name');
            $table->string('pic_crew');
            $table->date('booking_date');
            $table->string('time_slot');
            $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled'])->default('scheduled');
            $table->foreignId('created_by_admin_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('studio_bookings');
    }
};