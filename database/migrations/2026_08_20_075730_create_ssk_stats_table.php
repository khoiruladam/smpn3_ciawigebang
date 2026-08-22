<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ssk_stats', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('ti-chart-bar');   // nama icon Tabler, contoh: ti-school
            $table->string('label');                             // contoh: "Rombongan Belajar"
            $table->decimal('value', 10, 2);                     // angka yang dianimasikan (mendukung desimal)
            $table->string('suffix')->nullable();                // contoh: "+" untuk "540+"
            $table->unsignedTinyInteger('decimals')->default(0); // jumlah angka di belakang koma
            $table->string('sub')->nullable();                   // contoh: "Kelas VII - IX"
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ssk_stats');
    }
};