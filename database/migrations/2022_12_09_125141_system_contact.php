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
        Schema::create('system_contact', function (Blueprint $table) {
            $table->id();
            $table->integer('contact_direct')->default(0)->comment('ไอดีข้อความที่ตอบกลับ');
            $table->integer('contact_person_id')->default(0)->comment('ไอดีผู้คอมเม้น');
            $table->integer('contact_person_type')->default(0)->comment('ตำแหน่งของผู้คอมเม้น (0=member,1=buyer,2=admin,3=system)');
            $table->integer('contact_status')->default(0)->comment('0=ยังไม่อ่าน,1=อ่านแล้ว');
            $table->string('contact_name')->nullable()->comment('หัวข้อ');
            $table->string('contact_email')->nullable()->comment('หัวข้อ');
            $table->string('contact_title')->nullable()->comment('หัวข้อ');
            $table->text('contact_detail')->nullable()->comment('รายละเอียด');
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
        Schema::dropIfExists('system_contact');
    }
};
