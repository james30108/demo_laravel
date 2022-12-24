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
        Schema::create('system_login', function (Blueprint $table) {
            $table->id();
            $table->integer('login_person_id')->default(0)->comment('รหัสสมาชิก');
            $table->integer('login_person_type')->default(0)->comment('0=member,1=admin,2=buyer');
            $table->string('login_ip')->nullable()->comment('ไอพีแอดเดรส');
            $table->string('login_detail')->nullable()->comment('รหัสสมาชิกในผัง');
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
        Schema::dropIfExists('system_login');
    }
};
