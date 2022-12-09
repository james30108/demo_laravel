<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Config;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'config_type' => 'report_style',
                'config_name' => 'รูปแบบการคำนวนคอมมิชชั่น',
            ],
            [
                'config_type' => 'report_type',
                'config_name' => 'ตัดยอด',
            ],
            [
                'config_type' => 'report_fee1',
                'config_name' => 'ค่าธรรมเนียม',
            ],
            [
                'config_type' => 'report_fee2',
                'config_name' => 'ค่าธรรมเนียม (%)',
            ],
            [
                'config_type' => 'report_min',
                'config_name' => 'เงินปันผลขั้นต่ำ',
            ],
            [
                'config_type' => 'report_max',
                'config_name' => 'เงินปันผลสูงสุด',
            ],
            [
                'config_type' => 'withdraw_fee1',
                'config_name' => 'การถอนเงิน - ค่าธรรมเนียม',
            ],
            [
                'config_type' => 'withdraw_fee2',
                'config_name' => 'การถอนเงิน - ค่าธรรมเนียม 2 (%)',
            ],
            [
                'config_type' => 'withdraw_min',
                'config_name' => 'การถอนเงินขั้นต่ำ',
            ],
            [
                'config_type' => 'withdraw_max',
                'config_name' => 'การถอนเงินสูงสุด',
            ],
            [
                'config_type' => 'system_down_line_max',
                'config_name' => 'ลูกข่ายสูงสุด',
            ],
            [
                'config_type' => 'system_com_ppm',
                'config_name' => 'ค่ารักษายอด',
            ],
            [
                'config_type' => 'system_com_number',
                'config_name' => 'จำนวนชั้นเงินปันผล',
            ],
            [
                'config_type' => 'system_com_style',
                'config_name' => 'รูปแบบการรักษายอด',
            ],
            [
                'config_type' => 'system_switch',
                'config_name' => 'เปิด-ปิดระบบ',
            ],
            [
                'config_type' => 'system_lang',
                'config_name' => 'ระบบเปลี่ยนภาษา',
            ],
            [
                'config_type' => 'system_liner',
                'config_name' => 'ระบบสมาชิก / ธุรกิจเครือข่ายลำดับชั้น',
            ],
            [
                'config_type' => 'system_webpage',
                'config_name' => 'หน้าเว็บเพจ',
            ],
            [
                'config_type' => 'system_buyer',
                'config_name' => 'ระบบสมาชิกหน้าเว็บเพจ',
            ],
            [
                'config_type' => 'system_class',
                'config_name' => 'ระบบตำแหน่ง',
            ],
            [
                'config_type' => 'system_admin_buy',
                'config_name' => 'ระบบการซื้อด่วนของแอดมิน',
            ],
            [
                'config_type' => 'system_e_wallet',
                'config_name' => 'ระบบกระเป๋าเงิน',
            ],
            [
                'config_type' => 'system_member_expire',
                'config_name' => 'ระบบการซื้อด่วนของแอดมิน',
            ],
            [
                'config_type' => 'system_stock',
                'config_name' => 'ระบบสต๊อกสอนค้า',
            ],
            [
                'config_type' => 'system_tracking',
                'config_name' => 'ระบบติดตามการขนส่งสินค้า',
            ],
            [
                'config_type' => 'system_liner2',
                'config_name' => 'ระบบคอมมิชชั่นพิเศษ',
            ],
            [
                'config_type' => 'system_address',
                'config_name' => 'ระบบบันทึกที่อยู่',
            ],
            [
                'config_type' => 'system_pay',
                'config_name' => 'ระบบแจ้งชำระเงิน',
            ],
            [
                'config_type' => 'system_comment',
                'config_name' => 'ระบบความคิดเห็น',
            ],
            [
                'config_type' => 'system_com_withdraw',
                'config_name' => 'ระบบแจ้งถอนค่าคอมฯ',
            ],
            [
                'config_type' => 'system_product_type2',
                'config_name' => 'ประเภทสินค้าที่ 2',
            ],
            [
                'config_type' => 'system_e_commerce',
                'config_name' => 'ระบบซื้อสินค้า',
            ],
            [
                'config_type' => 'system_thread',
                'config_name' => 'ระบบบทความ',
            ],
            [
                'config_type' => 'system_insert_member',
                'config_name' => 'ระบบเพิ่มสมาชิก',
            ],
            [
                'config_type' => 'system_order_stack',
                'config_name' => 'ระบบซื้อแบบเรียงคิว',
            ],
        ];
        Config::insert($data);
    }
}
