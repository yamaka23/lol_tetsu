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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // アイテム名は一意
            $table->string('image')->nullable(); // 画像URLはオプション
            $table->string('language')->default('ja_JP'); // 言語はデフォルトで日本語
            $table->json('stats')->nullable(); // アイテムのステータスをJSON形式で保存
            $table->text('description')->nullable(); // アイテムの効果をテキスト形式で保存
            $table->string('version')->nullable(); // バージョン
            $table->json('tags')->nullable(); // アイテムのタイプ（例：防具、武器など）
            $table->integer('gold')->nullable(); // アイテムの価格をJSON形式で保存
            $table->boolean('is_into')->default(false); // アイテムが他のアイテムに組み込まれるかどうか
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
