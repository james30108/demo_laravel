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
        Schema::create('system_address', function (Blueprint $table) {
            $table->id();
            $table->integer('address_member')->comment('เชื่อมจาก member_id ในตาราง system_member');
            $table->string('address_detail')->comment('ที่อยู่');
            $table->string('address_district')->comment('ตำบล');
            $table->string('address_amphure')->comment('อำเภอ');
            $table->string('address_province')->comment('จังหวัด');
            $table->string('address_zipcode')->comment('รหัสไปรษณีย์');
            $table->integer('address_type')->default(0)->comment('0=default, 1=จัดส่งสินค้า');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_address');
    }
};
