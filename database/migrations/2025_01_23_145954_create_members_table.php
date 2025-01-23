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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birthday')->nullable();
            $table->string('constellation')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('grade')->nullable();
            $table->string('color1')->nullable();
            $table->string('color2')->nullable();
            $table->string('selection')->nullable();
            $table->boolean('graduation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
