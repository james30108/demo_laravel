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
        Schema::create('system_admin', function (Blueprint $table) {
            $table->id();
            $table->string('admin_user')->unique()->comment('สำหรับ login เข้าระบบ');
            $table->string('password');
            $table->string('admin_name')->comment('ชื่อในระบบ');
            $table->integer('admin_lang')->default(0)->comment('ภาษาในระบบ 0=TH,1=ENG');
            $table->integer('admin_status')->default(1)->comment('0=programer,1=admin');
            $table->string('admin_permission')->default(0)->comment('สถานะการเป็น vip 0=ธรรมดา, 1=VIP');
            $table->timestamps();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('system_admin');
    }
};
