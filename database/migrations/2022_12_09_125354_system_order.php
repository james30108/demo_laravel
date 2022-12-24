<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_order', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->nullable()->comment('รหัสรายการสั่งซื้อ');
            $table->integer('order_person_id')->default(0)->comment('ไอดีผู้ซื้อ');
            $table->integer('order_person_type')->default(0)->comment('0=member,1=buyer');
            $table->float('order_price')->default(0)->comment('ราคาที่ต้องชำระเงิน (รวมค่าขนส่งแล้ว)');
            $table->float('order_point')->default(0)->comment('คะแนนรวมที่ได้รับ');
            $table->integer('order_quantity')->default(0)->comment('จำนวนรวม');
            $table->string('order_name')->nullable()->comment('ชื่อผู้ซื้อ');
            $table->string('order_tel')->nullable()->comment('เบอร์โทรฯ');
            $table->string('order_address')->nullable()->comment('ที่อยู่จัดส่ง');
            $table->string('order_district')->nullable()->comment('ตำบล');
            $table->string('order_amphur')->nullable()->comment('อำเภอ');
            $table->string('order_province')->nullable()->comment('จังหวัด');
            $table->string('order_zipcode')->nullable()->comment('รหัสไปรษณีย์');
            $table->string('order_track_name')->nullable()->comment('บริษัทขนส่ง');
            $table->string('order_track_id')->nullable()->comment('เลขติดตามพัสดุ');
            $table->text('order_detail')->nullable()->comment('ข้อมูลเพิ่มเติม');
            $table->float('order_freight')->default(0)->comment('ค่าขนส่งรวม');
            $table->integer('order_status')->default(0)->comment('0=waiting,1=admin cancel,2=member cancel,3=delivered,4=success');
            $table->integer('order_type')->default(0)->comment('0=ซื้อแบบปกติ (เข้าผัง),1=ซื้อพิเศษ (ซื้อเพื่อถอนฯ)');
            $table->integer('order_pay_type')->default(0)->comment('0=ธรรมดา,1=e-wallet,2=ซื้อโดยแอดมิน,3=ewalletโดยแอดมิน');
            $table->integer('order_cut_report')->default(0)->comment('ตัดรายงานการสั่งซื้อ');
            $table->integer('order_cut')->default(0)->comment('สถานะการตัดยอดสำหรับใช้ในการคำนวน (ตัดพร้อมการตัดยอด)');
            $table->float('order_etc')->default(0)->comment('เก็บค่าพิเศษ');
            $table->float('order_etc2')->default(0)->comment('เก็บค่าพิเศษ 2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_order');
    }
};
