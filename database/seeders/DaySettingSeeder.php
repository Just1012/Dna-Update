<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DaySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('day_settings')->insert([
            [
                'name' => 'Saturday',
                'status' => 0,
            ],
            [
                'name' => 'Sunday',
                'status' => 0,
            ],
            [
                'name' => 'Monday',
                'status' => 0,
            ],
            [
                'name' => 'Tuesday',
                'status' => 0,
            ],
            [
                'name' => 'Wednesday',
                'status' => 0,
            ],
            [
                'name' => 'Thursday',
                'status' => 0,
            ],
            [
                'name' => 'Friday',
                'status' => 0,
            ],
        ]);
    }
}
