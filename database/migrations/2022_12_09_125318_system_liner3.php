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
        Schema::create('system_liner3', function (Blueprint $table) {
            $table->id();
            $table->string('liner3_code')->nullable()->comment('รหัสสมาชิกในผัง');
            $table->integer('liner3_member')->default(0)->comment('ไอดีสมาชิก');
            $table->integer('liner3_direct')->default(0)->comment('ไอดีแม่ข่าย');
            $table->integer('liner3_downline_first')->default(0)->comment('จำนวนลูกข่ายชั้นแรก');
            $table->integer('liner3_downline_all')->default(0)->comment('จำนวนลูกข่าย');
            $table->integer('liner3_type')->default(0)->comment('ประเภท');
            $table->integer('liner3_class')->default(1)->comment('ลำดับชั้น');
            $table->integer('liner3_status')->default(0)->comment('สถานะ');
            $table->float('liner3_point')->default(0)->comment('คะแนน');
            $table->float('liner3_etc')->default(0)->comment('เก็บค่าพิเศษ');
            $table->float('liner3_etc2')->default(0)->comment('เก็บค่าพิเศษ 2');
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
        Schema::dropIfExists('system_liner3');
    }
};
