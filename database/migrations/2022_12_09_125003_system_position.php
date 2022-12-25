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
        Schema::create('system_position', function (Blueprint $table) {
            $table->id();
            $table->string('position_name')->nullable()->comment('ชื่อตำแหน่ง');
            $table->string('position_image')->nullable()->comment('รูปตำแหน่ง');
            $table->integer('position_match_level')->default(0)->comment('จำนวนชั้นที่รับเงินปันผล');
            $table->float('position_point')->default(0)->comment('เงินปันผลประจำตำแหน่ง');
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
        Schema::dropIfExists('system_position');
    }
};
