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
        Schema::create('system_bank', function (Blueprint $table) {
            $table->id();
            $table->string('bank_code')->nullable()->comment('รหัสธนาคาร');
            $table->string('bank_acr')->nullable()->comment('อักษรย่อธนาคาร');
            $table->string('bank_name_th')->nullable()->comment('ชื่อภาษาไทย');
            $table->string('bank_name_eng')->nullable()->comment('ชื่อภาษาอังกฤษ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_bank');
    }
};
