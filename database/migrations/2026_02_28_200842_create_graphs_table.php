<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('graphs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();          // URL用: /graphs/{slug}
            $table->string('title');                   // 表示タイトル
            $table->text('description')->nullable();   // 説明文（SEO用にも）
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('graphs');
    }
};