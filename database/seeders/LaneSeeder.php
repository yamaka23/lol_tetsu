<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LaneSeeder extends Seeder
{
    public function run(): void
    {
        $lanes = ['TOP', 'JG', 'MID', 'BOT', 'SUP'];

        foreach ($lanes as $lane) {
            DB::table('lanes')->updateOrInsert(
                ['name' => $lane], // 一意キー
                [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
