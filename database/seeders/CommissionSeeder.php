<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Commission;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['commission_name' => 'ชั้นที่ 1',],
            ['commission_name' => 'ชั้นที่ 2'],
            ['commission_name' => 'ชั้นที่ 3'],
            ['commission_name' => 'ชั้นที่ 4'],
            ['commission_name' => 'ชั้นที่ 5'],
            ['commission_name' => 'ชั้นที่ 6'],
            ['commission_name' => 'ชั้นที่ 7'],
            ['commission_name' => 'ชั้นที่ 8'],
            ['commission_name' => 'ชั้นที่ 9'],
            ['commission_name' => 'ชั้นที่ 10'],
        ];
        Commission::insert($data);
    }
}
