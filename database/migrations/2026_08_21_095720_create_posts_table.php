<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Akademik'); // Akademik, Ekskul, Prestasi, Pengumuman
            $table->string('image')->nullable(); // Foto utama / cover
            $table->text('excerpt')->nullable(); // Ringkasan pendek untuk card
            $table->longText('body'); // Isi berita (Quill WYSIWYG Editor)
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};