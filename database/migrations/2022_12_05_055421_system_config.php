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
        Schema::create('system_config', function (Blueprint $table) {
            $table->id();
            $table->string('config_type')->nullable()->comment('ชื่อตัวแปร');
            $table->string('config_name')->nullable()->comment('รายละเอียด');
            $table->string('config_value')->default(0)->comment('0=ปิด,1=เปิด');
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
        Schema::dropIfExists('system_config');
    }
};
