<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('colorname1')->nullable()->after('color1');
            $table->string('colorname2')->nullable()->after('color2');
        });
    }
    
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('colorname1');
            $table->dropColumn('colorname2');
        });
    }
};
