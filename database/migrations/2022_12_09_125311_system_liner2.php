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
        Schema::create('system_liner2', function (Blueprint $table) {
            $table->id();
            $table->string('liner2_code')->nullable()->comment('รหัสสมาชิกในผัง');
            $table->integer('liner2_member')->default(0)->comment('ไอดีสมาชิก');
            $table->integer('liner2_direct')->default(0)->comment('ไอดีแม่ข่าย');
            $table->integer('liner2_downline_first')->default(0)->comment('จำนวนลูกข่ายชั้นแรก');
            $table->integer('liner2_downline_all')->default(0)->comment('จำนวนลูกข่าย');
            $table->integer('liner2_type')->default(0)->comment('ประเภท');
            $table->integer('liner2_class')->default(1)->comment('ลำดับชั้น');
            $table->integer('liner2_status')->default(0)->comment('สถานะ');
            $table->float('liner2_point')->default(0)->comment('คะแนน');
            $table->float('liner2_etc')->default(0)->comment('เก็บค่าพิเศษ');
            $table->float('liner2_etc2')->default(0)->comment('เก็บค่าพิเศษ 2');
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
        Schema::dropIfExists('system_liner2');
    }
};
