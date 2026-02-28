<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('graph_edges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('graph_id')->constrained('graphs')->cascadeOnDelete();

            $table->foreignId('from_node_id')->constrained('graph_nodes')->cascadeOnDelete();
            $table->foreignId('to_node_id')->constrained('graph_nodes')->cascadeOnDelete();

            $table->foreignId('relation_type_id')->nullable()->constrained('relation_types')->nullOnDelete();

            $table->string('label')->nullable();           // 表示ラベル（例：親友/師匠）
            $table->boolean('is_directed')->default(false); // 矢印の有無（尊敬等）
            $table->unsignedInteger('weight')->default(1);  // 太さや優先度に使える
            $table->text('note')->nullable();               // エピソード/根拠

            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['graph_id', 'relation_type_id']);
            $table->index(['graph_id', 'from_node_id']);
            $table->index(['graph_id', 'to_node_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('graph_edges');
    }
};