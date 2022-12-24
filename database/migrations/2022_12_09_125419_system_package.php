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
        Schema::create('system_package', function (Blueprint $table) {
            $table->id();
            $table->integer('package_main')->default(0)->comment('');
            $table->integer('package_product')->default(0)->comment('ไอดีสินค้า');
            $table->string('package_name')->nullable()->comment('ชื่อแพ็กเกจ');
            $table->integer('package_quantity')->default(0)->comment('จำนวนสินค้า');
            $table->float('package_point')->default(0)->comment('คะแนน');
            $table->float('package_price')->default(0)->comment('ราคา');
            $table->integer('package_status')->default(0)->comment('สถานะ');
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
        Schema::dropIfExists('system_package');
    }
};
