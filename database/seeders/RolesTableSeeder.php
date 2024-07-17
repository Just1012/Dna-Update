<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'Admin'],
            ['name' => 'User'],
            ['name' => 'Agent'],
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Mohamed Adel',
                'phone' => '10239332',
                'password' => Hash::make('12341234'),
                'image' => null,
                'role_id'=>1
            ],
        ]);
    }
}
