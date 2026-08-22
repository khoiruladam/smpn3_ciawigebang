<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Untuk alt gambar / judul singkat
            $table->text('caption'); // Keterangan lengkap foto
            $table->string('category')->default('Kegiatan'); // Contoh: Akademik, Olahraga, dll.
            $table->string('image'); // Path file gambar
            $table->boolean('is_featured')->default(false); // Sebagai momen utama (besar)
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};