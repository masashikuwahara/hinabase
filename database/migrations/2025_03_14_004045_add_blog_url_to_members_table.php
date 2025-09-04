<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('members', 'blog_url')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('blog_url')->nullable()->after('introduction');
            });
        }
    }
    
    public function down()
    {
        if (Schema::hasColumn('members', 'blog_url')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('blog_url');
            });
        }
    }
};
