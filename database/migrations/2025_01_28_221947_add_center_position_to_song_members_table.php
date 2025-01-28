<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('song_members', function (Blueprint $table) {
            // センターポジションカラムを追加（デフォルトはfalse）
            $table->boolean('is_center')->default(false)->after('member_id');
        });
    }
    
    public function down()
    {
        Schema::table('song_members', function (Blueprint $table) {
            // カラムを削除
            $table->dropColumn('is_center');
        });
    }
};
