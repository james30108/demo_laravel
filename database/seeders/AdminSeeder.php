<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            [
                'admin_user' => "programer",
                'password' => '$2y$10$Ldd0WYupe33Spcm0iByJK.1ASnVR5DqDC7dw2EIj2m3wbhq7R1aUG',
                'admin_name' => "programer_1",
            ],
        ];
        Admin::insert($admin);
    }
}
