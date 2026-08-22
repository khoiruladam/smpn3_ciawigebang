<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Menambahkan kolom baru jika belum ada
            if (!Schema::hasColumn('settings', 'key')) {
                $table->string('key')->unique()->after('id');
            }
            if (!Schema::hasColumn('settings', 'value')) {
                $table->text('value')->nullable()->after('key');
            }
            if (!Schema::hasColumn('settings', 'group')) {
                $table->string('group')->default('general')->after('value');
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['key', 'value', 'group']);
        });
    }
};