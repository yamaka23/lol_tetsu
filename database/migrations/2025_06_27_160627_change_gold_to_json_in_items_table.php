<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * goldカラムをJSON型に変換
     */
    public function up(): void
    {
        // 一時カラム gold_temp を追加
        Schema::table('items', function (Blueprint $table) {
            $table->json('gold_temp')->nullable();
        });

        // gold のデータを gold_temp にコピー
        DB::statement('UPDATE items SET gold_temp = gold');

        // goldカラムを削除
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('gold');
        });

        // 新しい goldカラムをJSON型で追加
        Schema::table('items', function (Blueprint $table) {
            $table->json('gold')->nullable();
        });

        // gold_temp のデータを gold にコピー
        DB::statement('UPDATE items SET gold = gold_temp');

        // gold_temp を削除
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('gold_temp');
        });
    }

    /**
     * Reverse the migrations.
     * goldカラムをint型に戻す
     */
    public function down(): void
    {
        // gold_temp を追加
        Schema::table('items', function (Blueprint $table) {
            $table->integer('gold_temp')->nullable();
        });

        // gold のデータを gold_temp にコピー
        DB::statement('UPDATE items SET gold_temp = gold');

        // goldカラムを削除
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('gold');
        });

        // goldカラムをintで再作成
        Schema::table('items', function (Blueprint $table) {
            $table->integer('gold')->nullable();
        });

        // gold_temp のデータを gold にコピー
        DB::statement('UPDATE items SET gold = gold_temp');

        // gold_temp を削除
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('gold_temp');
        });
    }
    
};
