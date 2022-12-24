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
        Schema::create('system_transfer', function (Blueprint $table) {
            $table->id();
            $table->integer('transfer_from')->default(0)->comment('ไอดีสมาชิกที่ทำการโอน');
            $table->integer('transfer_to')->default(0)->comment('ไอดีสมาชิกที่รับเงิน');
            $table->float('transfer_money')->default(0)->comment('จำนวนเงินที่โอน');
            $table->integer('transfer_status')->default(0)->comment('สถานะ');
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
        Schema::dropIfExists('system_transfer');
    }
};
