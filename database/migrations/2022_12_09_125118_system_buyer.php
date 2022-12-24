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
        Schema::create('system_buyer', function (Blueprint $table) {
            $table->id();
            $table->integer('buyer_direct')->default(0)->comment('ผู้แนะนำ');
            $table->string('buyer_name')->nullable()->comment('ชื่อ');
            $table->string('buyer_tel')->nullable()->comment('เบอร์โทร');
            $table->string('buyer_email')->nullable()->comment('อีเมล');
            $table->string('password')->nullable()->comment('พาสเวิร์ด');
            $table->string('buyer_address')->nullable()->comment('ที่อยู่');
            $table->string('buyer_district')->nullable()->comment('ตำบล');
            $table->string('buyer_amphure')->nullable()->comment('อำเภอ');
            $table->string('buyer_province')->nullable()->comment('จังหวัด');
            $table->string('buyer_zipcode')->nullable()->comment('รหัสไปรษณีย์');
            $table->integer('buyer_status')->default(0)->comment('สถานะ');
            $table->integer('buyer_lang')->default(0)->comment('ภาษา');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_buyer');
    }
};
