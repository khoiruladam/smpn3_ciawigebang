<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('jabatan'); // Contoh: Kepala Sekolah, Guru Matematika, Petugas Kebersihan
            $table->string('sub')->nullable(); // Contoh: Pembina Utama, Penanggung Jawab Area A
            $table->string('category')->default('guru'); // Bersifat string bebas (kepsek, wakel, guru, staff, kebersihan, dll)
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};