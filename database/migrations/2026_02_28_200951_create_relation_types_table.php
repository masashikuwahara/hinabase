<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('relation_types', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();      // "friend", "同期", etc
            $table->string('name_ja');             // 表示名
            $table->string('name_en')->nullable(); // 将来の英語対応
            $table->string('color')->nullable();   // 例: "#ff3b30" (任意)
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relation_types');
    }
};