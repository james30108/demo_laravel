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
        Schema::create('system_member', function (Blueprint $table) {
            $table->id();
            $table->string('member_name');
            $table->string('member_email')->unique();
            $table->string('password');
            $table->string('member_title_name')->nullable()->comment('คำนำหน้านาม');
            $table->string('member_code')->nullable()->comment('รหัสสมาชิก');
            $table->string('member_tel')->nullable()->comment('เบอร์โทรฯ');
            $table->integer('member_bank')->default(0)->comment('ไอดีธนาคาร');
            $table->string('member_bank_own')->nullable()->comment('ชื่อเจ้าของบัญชี');
            $table->string('member_bank_id')->nullable()->comment('หมายเลขบัญชีฯ');
            $table->integer('member_position')->default(0)->comment('ตำแหน่ง');
            $table->string('member_code_id')->nullable()->comment('รหัสบัตรประชาชน')->unique();
            $table->string('member_token_line')->nullable()->comment('ไลน์โทเค่น');
            $table->integer('member_status')->default(0)->comment('สถานะการใช้งาน');
            $table->float('member_point', 8, 2)->default(0)->comment('คำแนน');
            $table->float('member_point_month', 8, 2)->default(0)->comment('คะแนน/เดือน');
            $table->float('member_e_wallet', 8, 2)->default(0)->comment('เงินในบัญชี');
            $table->string('member_image_cover')->nullable()->comment('รูปปก');
            $table->string('member_image_card')->nullable()->comment('รูปประชาชน');
            $table->string('member_image_bank')->nullable()->comment('รูปบัญชีธนาคาร');
            $table->integer('member_lang')->default(0)->comment('ภาษาในระบบ');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('system_member');
    }
};
