<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('graph_nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('graph_id')->constrained('graphs')->cascadeOnDelete();

            // member_idを貼ると「HINABASEのメンバーと紐づくノード」
            // NULLなら「自由ノード（例：番組、ユニット名、概念など）」
            $table->unsignedBigInteger('member_id')->nullable();

            $table->string('label'); // 表示名（memberの場合も、ここに退避しておくと強い）
            $table->string('image_url')->nullable(); // 任意：アバター/シルエット等のURL

            // 将来的な「手動配置」用（今はNULLでOK）
            $table->decimal('pos_x', 10, 3)->nullable();
            $table->decimal('pos_y', 10, 3)->nullable();
            $table->boolean('is_position_locked')->default(false);

            $table->unsignedInteger('size')->nullable(); // ノードサイズ調整（任意）
            $table->json('meta')->nullable();            // 任意の拡張（例：期、属性など）

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['graph_id', 'sort_order']);
            $table->index(['graph_id', 'member_id']);

            // members テーブルが存在する前提ならFKを貼ってOK（存在しない場合はコメントアウト）
            // $table->foreign('member_id')->references('id')->on('members')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('graph_nodes');
    }
};