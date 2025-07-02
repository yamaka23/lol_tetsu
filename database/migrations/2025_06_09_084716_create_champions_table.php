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
        Schema::create('champions', function (Blueprint $table) {
            $table->string('id')->primary(); // チャンピオンIDは一意
            $table->string('name'); // チャンピオン名は一意
            $table->string('image')->nullable(); // 画像URLはオプション
            $table->string('language')->default('ja_JP'); // 言語はデフォルトで日本語
            $table->string('version')->nullable(); // バージョン
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('champions');
    }
};
