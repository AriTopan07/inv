<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('groups')->insert([
            [
                'name' => 'Super Admin',
                'description' => 'Hak Akses untuk Super Admin',
            ],
            [
                'name' => 'Admin',
                'description' => 'Hak Akses untuk Admin',
            ],
            [
                'name' => 'User',
                'description' => 'Hak Akses untuk user',
            ]
        ]);
    }
}
