<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('popularities', function (Blueprint $table) {
            // 複合インデックスを追加
            $table->index(['type', 'views']);
        });
    }

    public function down(): void
    {
        Schema::table('popularities', function (Blueprint $table) {
            $table->dropIndex(['type', 'views']);
        });
    }
};
