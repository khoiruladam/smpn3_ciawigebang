<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ekskuls', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Ekskul (contoh: Pramuka)
            $table->string('slug')->unique(); // URL ramah SEO
            $table->string('icon')->default('ti-star'); // Ikon Tabler
            $table->string('category')->nullable(); // Tag/Kategori (contoh: Olahraga, Seni)
            $table->string('cover_image')->nullable(); // Foto banner/cover utama
            $table->text('gallery')->nullable(); // Menyimpan banyak foto galeri dalam format JSON/Array
            $table->text('short_description'); // Teks ringkas untuk kartu
            $table->longText('description'); // Konten detail (WYSIWYG HTML)
            $table->integer('sort_order')->default(0); // Urutan tampil
            $table->boolean('is_published')->default(true); // Status tayang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekskuls');
    }
};