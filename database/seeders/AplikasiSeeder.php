<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AplikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('aplikasis')
            ->insert([
                [
                    'title' => 'Sistem Pengambilan Keputusan',
                    'footer' => 'Copyright © 2023 SPK | UMSIDA. All rights reserved',
                    'sidebar' => 'dark',
                ],
            ]);
    }
}
