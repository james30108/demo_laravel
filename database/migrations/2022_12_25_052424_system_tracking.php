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
        Schema::create('system_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_name')->nullable()->comment('บริษัท');
            $table->string('tracking_link')->nullable()->comment('ลิงค์นำพาไปสู่หน้าเว็บสำหรับตรวจสอบรหัสติดตามพัสดุ');
            $table->float('tracking_weight')->default(0)->comment('น้ำหนักในการคำนวนต่อราคา (กรัม)');
            $table->float('tracking_price')->default(0)->comment('ราคา');
            $table->float('tracking_max_weight')->default(0)->comment('น้ำหนักมากที่สุดที่ใช้ในการคำนวน');
            $table->float('tracking_max_price')->default(0)->comment('น้ำหนักมากที่สุดที่ใช้ในการคำนวน');
            $table->text('tracking_detail')->nullable()->comment('รายละเอียดเพิ่มเติม');
            $table->integer('tracking_status')->default(0)->comment('สถานะ');
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
        Schema::dropIfExists('system_tracking');
    }
};
