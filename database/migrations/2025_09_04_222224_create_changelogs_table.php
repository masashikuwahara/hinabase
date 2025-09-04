<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('changelogs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('version')->nullable();
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('link')->nullable();
            $table->boolean('pinned')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('changelogs');
    }
};
