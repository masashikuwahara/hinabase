<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('popularities', function (Blueprint $table) {
            $table->id();
            $table->string('type');              // 'member' | 'song'
            $table->unsignedBigInteger('entity_id');
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
            $table->unique(['type','entity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('popularities');
    }
};
