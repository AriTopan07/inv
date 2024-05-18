<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_actions')
            ->insert([
                [
                    'name' => 'view',
                    'description' => 'Hak untuk mengakses halaman',
                ],
                [
                    'name' => 'add',
                    'description' => 'Tombol aksi untuk menambah data',
                ],
                [
                    'name' => 'edit',
                    'description' => 'Tombol aksi untuk mengedit data',
                ],
                [
                    'name' => 'delete',
                    'description' => 'Tombol aksi untuk menghapus data',
                ],
                [
                    'name' => 'detail',
                    'description' => 'Tombol aksi untuk menampilkan data',
                ],
                [
                    'name' => 'verification',
                    'description' => 'Tombol aksi untuk memverifikasi data',
                ],
                [
                    'name' => 'exports',
                    'description' => 'Tombol aksi untuk mengunduh data',
                ],
                [
                    'name' => 'mutasi',
                    'description' => 'Tombol aksi untuk mutasi barang',
                ],
                [
                    'name' => 'keluar',
                    'description' => 'Tombol aksi untuk barang keluar',
                ],
            ]);
    }
}
