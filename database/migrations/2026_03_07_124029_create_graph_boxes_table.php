<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('graph_boxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('graph_id')->constrained('graphs')->cascadeOnDelete();

            $table->string('label')->nullable();      // 箱のタイトル（例：関西組）
            $table->string('color')->nullable();      // 枠色（例：#ef4444）
            $table->decimal('x', 10, 3);              // グラフ座標（中心x）
            $table->decimal('y', 10, 3);              // グラフ座標（中心y）
            $table->decimal('w', 10, 3);              // グラフ座標（幅）
            $table->decimal('h', 10, 3);              // グラフ座標（高さ）
            $table->unsignedInteger('z')->default(0); // 重なり順（大きいほど上）
            $table->timestamps();

            $table->index(['graph_id','z']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graph_boxes');
    }
};
