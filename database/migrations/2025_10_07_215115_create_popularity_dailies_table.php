<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('popularity_dailies', function (Blueprint $table) {
            $table->id();
            $table->string('type', 255)->index();            // 'member' or 'song' 等
            $table->unsignedBigInteger('entity_id')->index();
            $table->date('date')->index();                   // 「その日の分」を1行に集約
            $table->unsignedBigInteger('views')->default(0)->index();
            $table->timestamps();

            $table->unique(['type', 'entity_id', 'date'], 'popular_daily_unique');
        });
    }
    public function down(): void {
        Schema::dropIfExists('popularity_dailies');
    }
};