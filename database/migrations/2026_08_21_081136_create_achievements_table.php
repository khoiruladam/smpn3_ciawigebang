<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable(); // Misal: Tingkat Kabupaten / Provinsi
            $table->string('year', 4); // Misal: 2025
            $table->string('icon')->default('ti-trophy');
            $table->string('cover_image')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description');
            $table->json('gallery')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};