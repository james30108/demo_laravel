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
            ['commission_name' => 'class 1',],
            ['commission_name' => 'class 2'],
            ['commission_name' => 'class 3'],
            ['commission_name' => 'class 4'],
            ['commission_name' => 'class 5'],
            ['commission_name' => 'class 6'],
            ['commission_name' => 'class 7'],
            ['commission_name' => 'class 8'],
            ['commission_name' => 'class 9'],
            ['commission_name' => 'class 10'],
        ];
        Commission::insert($data);
    }
}
