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
        Schema::create('system_thread', function (Blueprint $table) {
            $table->id();
            $table->string('thread_title')->nullable()->comment('หัวข้อ');
            $table->string('thread_intro')->nullable()->comment('ย่อหน้าโฆษณา');
            $table->text('thread_detail')->nullable()->comment('รายละเอียด');
            $table->integer('thread_type')->default(0)->comment('ประเภท');
            $table->integer('thread_highlight')->default(0)->comment('ไฮไลท์');
            $table->integer('thread_status')->default(0)->comment('สถานะ');
            $table->string('thread_image_cover')->nullable()->comment('รูปปก');
            $table->string('thread_image_1')->nullable()->comment('รูปประกอบ');
            $table->string('thread_image_2')->nullable()->comment('รูปประกอบ');
            $table->string('thread_image_3')->nullable()->comment('รูปประกอบ');
            $table->string('thread_image_4')->nullable()->comment('รูปประกอบ');
            $table->string('thread_image_5')->nullable()->comment('รูปประกอบ');
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
        Schema::dropIfExists('system_thread');
    }
};
