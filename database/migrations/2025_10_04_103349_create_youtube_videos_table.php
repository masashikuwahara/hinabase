<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('youtube_videos', function (Blueprint $t) {
      $t->id();
      $t->string('video_id')->unique();
      $t->string('title');
      $t->string('channel_id')->index();
      $t->string('channel_title')->nullable();
      $t->timestamp('published_at')->index();
      $t->string('thumbnail_url')->nullable();
      $t->unsignedBigInteger('view_count')->default(0)->index();
      $t->unsignedBigInteger('like_count')->default(0);
      $t->unsignedBigInteger('comment_count')->default(0);
      $t->string('duration')->nullable(); // ISO8601 PT4M32S
      $t->timestamps();
    });
  }
  public function down(): void { Schema::dropIfExists('youtube_videos'); }
};
