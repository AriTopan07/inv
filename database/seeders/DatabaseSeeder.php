<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AplikasiSeeder::class);
        $this->call(MasterActionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(UserGroupSeeder::class);
        $this->call(MenuSectionSeeder::class);
        $this->call(MenuSeeder::class);
        // $this->call(ActionSeeder::class);
        // $this->call(ActionGroupSeeder::class);
    }
}
