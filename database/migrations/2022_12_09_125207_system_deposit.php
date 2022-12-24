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
        Schema::create('system_deposit', function (Blueprint $table) {
            $table->id();
            $table->integer('deposit_member')->default(0)->comment('ไอดีสมาชิก');
            $table->float('deposit_money')->default(0)->comment('จำนวนเงินที่เติม');
            $table->integer('deposit_bank')->default(0)->comment('ธนาคาร');
            $table->string('deposit_slip')->nullable()->comment('หลักฐานการโอนเงิน');
            $table->string('deposit_detail')->nullable()->comment('รายละเอียดอื่นๆ');
            $table->string('deposit_status')->nullable()->comment('0=waiting,1=success,2=cancel,3=by admin');
            $table->timestamp($column = 'deposit_create', $precision = 0)->comment('วันเวลาที่เติม');
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
        Schema::dropIfExists('system_deposit');
    }
};
