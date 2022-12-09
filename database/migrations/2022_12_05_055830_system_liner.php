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
        Schema::create('system_liner', function (Blueprint $table) {
            $table->id();
            $table->integer('liner_member')->comment('มาจาก member_id')->unsigned();
            $table->integer('liner_direct')->default(0)->comment('แม่ข่าย มากจาก liner_id');
            $table->integer('liner_count')->default(0)->comment('สมาชิกทั้งหมด');
            $table->integer('liner_count_day')->default(0)->comment('สมาชิกที่เพิ่มในวันนี้');
            $table->integer('liner_count_month')->default(0)->comment('สมาชิกที่เพิ่มในเดือนนี้');
            $table->integer('liner_status')->default(0)->comment('สถานะการรับคอมมิชชัน 0=ไม่ได้รับ, 1=ได้รับ');
            $table->integer('liner_type')->default(0)->comment('สถานะการเป็น vip 0=ธรรมดา, 1=VIP');
            $table->integer('liner_withdraw_count')->default(0)->comment('จำนวนสิทธิ์ในการถอนเงิน');
            $table->float('liner_point')->default(0)->comment('คะแนนโบนัส');
            $table->float('liner_etc')->default(0)->comment('เก็บค่าอื่นๆ');
            $table->float('liner_etc2')->default(0)->comment('เก็บค่าอื่นๆ2');
            $table->timestamp($column = 'liner_expire', $precision = 0)->comment('วันหมดอายุ');
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
        Schema::dropIfExists('system_liner');
    }
};
