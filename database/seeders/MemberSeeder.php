<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Liner;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $member = [
            [
                'member_name' => 'member 01',
                'member_email' => 'member001@gmail.com',
                'password' => "$2y$10$5Yfq3a4MnDFriNJqfK4Nl.eEk6P5fbVcdJHhDlGa5hsv9Gk0eMebG",
                'member_title_name' => "Mr",
                'member_code' => "0000001",
                'member_tel' => "0996944443",
                'member_code_id' => "000000000001",
            ],
            [
                'member_name' => 'member 02',
                'member_email' => 'member002@gmail.com',
                'password' => "$2y$10$5Yfq3a4MnDFriNJqfK4Nl.eEk6P5fbVcdJHhDlGa5hsv9Gk0eMebG",
                'member_title_name' => "Mr",
                'member_code' => "00000012",
                'member_tel' => "0996944443",
                'member_code_id' => "000000000002",
            ],
            [
                'member_name' => 'member 03',
                'member_email' => 'member003@gmail.com',
                'password' => "$2y$10$5Yfq3a4MnDFriNJqfK4Nl.eEk6P5fbVcdJHhDlGa5hsv9Gk0eMebG",
                'member_title_name' => "Mr",
                'member_code' => "0000003",
                'member_tel' => "0996944443",
                'member_code_id' => "000000000003",
            ],
            [
                'member_name' => 'member 04',
                'member_email' => 'member004@gmail.com',
                'password' => "$2y$10$5Yfq3a4MnDFriNJqfK4Nl.eEk6P5fbVcdJHhDlGa5hsv9Gk0eMebG",
                'member_title_name' => "Mr",
                'member_code' => "0000004",
                'member_tel' => "0996944443",
                'member_code_id' => "000000000004",
            ],
        ];
        $liner = [
            [
                'liner_member' => 1,
                'liner_direct' => 0,
                'liner_count' => 3,
                'liner_count_day' => 3,
                'liner_count_month' => 3,
            ],
            [
                'liner_member' => 2,
                'liner_direct' => 1,
                'liner_count' => 2,
                'liner_count_day' => 2,
                'liner_count_month' => 2,
            ],
            [
                'liner_member' => 3,
                'liner_direct' => 2,
                'liner_count' => 1,
                'liner_count_day' => 1,
                'liner_count_month' => 1,
            ],
            [
                'liner_member' => 4,
                'liner_direct' => 3,
                'liner_count' => 0,
                'liner_count_day' => 0,
                'liner_count_month' => 0,
            ],
        ];
        Member::insert($member);
        Liner::insert($liner);
    }
}
