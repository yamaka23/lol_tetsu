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
        Schema::create('main_runes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ルーンの名前（例：栄華）
            $table->string('icon')->nullable(); // 画像URLまたはファイル名
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_runes');
    }
};
