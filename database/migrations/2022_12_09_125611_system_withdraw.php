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
        Schema::create('system_withdraw', function (Blueprint $table) {
            $table->id();
            $table->integer('withdraw_member')->default(0)->comment('ไอดีสมาชิกที่ทำการโอน');
            $table->integer('withdraw_bank')->default(0)->comment('ไอดีธนาคาร');
            $table->string('withdraw_bank_own')->nullable()->comment('เจ้าของบัญชี');
            $table->string('withdraw_bank_id')->nullable()->comment('เลขบัญชี');
            $table->integer('withdraw_point')->default(0)->comment('ยอดเงินถอน');
            $table->integer('withdraw_full_point')->default(0)->comment('ยอดเงินสำหรับโอนคืนให้สมาชิก');
            $table->integer('withdraw_status')->default(0)->comment('0=waiting,1=success, 2=cancel');
            $table->integer('withdraw_cut')->default(0)->comment('0=default,1=cut');
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
        Schema::dropIfExists('system_withdraw');
    }
};
