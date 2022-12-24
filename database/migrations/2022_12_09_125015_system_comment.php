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
        Schema::create('system_comment', function (Blueprint $table) {
            $table->id();
            $table->integer('comment_direct')->default(0)->comment('ไอดีข้อความที่ตอบกลับ');
            $table->integer('comment_person_id')->default(0)->comment('ไอดีผู้คอมเม้น');
            $table->integer('comment_person_type')->default(0)->comment('ตำแหน่งของผู้คอมเม้น (0=สมาชิก,1=แอดมิน,2=ผู้ซื้อจากหน้าเว็บเพจ)');
            $table->integer('comment_type')->default(0)->comment('ประเภทที่มา (สินค้าหรือบล๊อก)');
            $table->integer('comment_link')->default(0)->comment('ไอดีของหัวข้อที่มา (สินค้าหรือบล๊อก)');
            $table->integer('comment_status')->default(0)->comment('0=ยังไม่อ่าน,1=อ่านแล้ว');
            $table->string('comment_title')->nullable()->comment('หัวข้อ');
            $table->text('comment_detail')->nullable()->comment('รายละเอียด');
            $table->string('comment_image_cover')->nullable()->comment('รูปประกอบ');
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
        Schema::dropIfExists('system_comment');
    }
};
