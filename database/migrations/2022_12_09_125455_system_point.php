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
        Schema::create('system_point', function (Blueprint $table) {
            $table->id();
            $table->integer('point_member')->default(0)->comment('ไอดีสมาชิก');
            $table->integer('point_order')->default(0)->comment('ไอดีรายการสั่งซื้อ');
            $table->integer('point_type')->default(0)->comment('0=รักษายอด,1=com,2=special');
            $table->float('point_bonus')->default(0)->comment('คะแนน');
            $table->integer('point_status')->default(0)->comment('0=default,1=cut');
            $table->string('point_detail')->nullable()->comment('รายละเอียด');
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
        Schema::dropIfExists('system_point');
    }
};
