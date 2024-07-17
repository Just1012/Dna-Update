<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShippingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $shippings = [
            ['governorate_id' => 1, 'area_id' => 1, 'shipping_time' => '10:00:00', 'shipping_price' => 60],
            ['governorate_id' => 1, 'area_id' => 2, 'shipping_time' => '12:00:00', 'shipping_price' => 45],
            // Add more shipping data here
        ];

        DB::table('shippings')->insert($shippings);
    }
}
