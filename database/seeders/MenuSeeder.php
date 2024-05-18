<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 1,
                'name_menu' => 'Ruangan',
                'url' => '/ruangan',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 1,
                'name_menu' => 'Kategori',
                'url' => '/kategori',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 2,
                'name_menu' => 'Barang Masuk',
                'url' => '/barang',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 2,
                'name_menu' => 'Barang Keluar',
                'url' => '/barang-keluar',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 2,
                'name_menu' => 'Inventaris',
                'url' => '/inventaris',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 3,
                'name_menu' => 'Mutasi Barang',
                'url' => '/mutasi-barang',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 4,
                'name_menu' => 'Laporan',
                'url' => '/laporan',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);


        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 5,
                'name_menu' => 'User',
                'url' => '/user',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 5,
                'name_menu' => 'Group',
                'url' => '/group',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 6,
                'name_menu' => 'Pengaturan Aplikasi',
                'url' => '/pengaturan-aplikasi',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 6,
                'name_menu' => 'Menu',
                'url' => '/menu',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 6,
                'name_menu' => 'Aksi',
                'url' => '/aksi',
                'icons' => '',
                'order' => 3,
                'status' => 'active',
            ]);
    }
}
