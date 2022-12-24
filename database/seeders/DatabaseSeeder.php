<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConfigSeeder::class);
        $this->call(CommissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(MemberSeeder::class);
    }
}
