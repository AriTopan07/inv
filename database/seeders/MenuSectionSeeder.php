<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Data Master',
                'order' => 0,
                'icons' => 'database',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Inventaris',
                'order' => 0,
                'icons' => 'book',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Mutasi',
                'order' => 0,
                'icons' => 'arrow-left-right',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Laporan',
                'order' => 0,
                'icons' => 'file-earmark-text',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Manajemen User',
                'order' => 0,
                'icons' => 'person-gear',
                'status' => 'active',
            ]);
        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Pengaturan',
                'order' => 0,
                'icons' => 'gear',
                'status' => 'active',
            ]);
    }
}
