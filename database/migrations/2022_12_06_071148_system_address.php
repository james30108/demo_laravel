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
            $table->integer('address_person_id')->default(0)->comment('id');
            $table->integer('address_person_type')->default(0)->comment('0=member,1=buyer');
            $table->string('address_detail')->nullable()->comment('ที่อยู่');
            $table->string('address_district')->nullable()->comment('ตำบล');
            $table->string('address_amphure')->nullable()->comment('อำเภอ');
            $table->string('address_province')->nullable()->comment('จังหวัด');
            $table->string('address_zipcode')->nullable()->comment('รหัสไปรษณีย์');
            $table->integer('address_type')->default(0)->comment('0=default, 1=จัดส่งสินค้า');
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
        Schema::dropIfExists('system_address');
    }
};
