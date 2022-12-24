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
        Schema::create('system_pay_refer', function (Blueprint $table) {
            $table->id();
            $table->string('pay_title')->nullable()->comment('หัวข้อ');
            $table->integer('pay_person_id')->default(0)->comment('ไอดีผู้ชำระเงิน');
            $table->integer('pay_person_type')->default(0)->comment('0=member,1=buyer');
            $table->string('pay_name')->nullable()->comment('เจ้าของบัญชีที่โอนเงิน');
            $table->integer('pay_order')->default(0)->comment('ไอดีรายาการสั่งซื้อ');
            $table->integer('pay_bank')->default(0)->comment('ธนาคารที่รับเงิน');
            $table->integer('pay_type')->default(0)->comment('0=จ่ายค่าสินค้า,1=จ่ายค่าสมัครสมาชิก');
            $table->integer('pay_status')->default(0)->comment('0=waiting,1=admin cancel,2=member cancel,3=success');
            $table->float('pay_money')->default(0)->comment('จำนวนเงิน');
            $table->string('pay_slip')->nullable()->comment('หลักฐานการโอนเงิน');
            $table->text('pay_detail')->nullable()->comment('ข้อมูลเพิ่มเติม');
            $table->timestamp($column = 'pay_create', $precision = 0)->comment('วันเวลาที่ชำระเงิน');
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
        Schema::dropIfExists('system_pay_refer');
    }
};
