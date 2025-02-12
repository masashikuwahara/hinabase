<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            // センターポジションカラムを追加（デフォルトはfalse）
            $table->string('nickname')->default(false)->after('name');
            $table->string('intro')->default(false)->after('graduation');
        });
    }
    
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            // カラムを削除
            $table->dropColumn('nickname');
            $table->dropColumn('intro');
        });
    }
};
