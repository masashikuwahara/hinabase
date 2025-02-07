<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->string('titlesong')->nullable()->after('arranger');
            $table->string('youtube')->nullable()->after('titlesong');
        });
    }
    
    public function down()
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('titlesong');
            $table->dropColumn('youtube');
        });
    }
};
