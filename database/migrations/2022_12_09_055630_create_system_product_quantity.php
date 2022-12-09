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
        Schema::create('system_product_quantity', function (Blueprint $table) {
            $table->id();
            $table->integer('product_quantity_main')->default(0)->comment('ไอดีสินค้า');
            $table->integer('product_quantity_old')->default(0)->comment('จำนวนคงเหลือก่อนเติม');
            $table->integer('product_quantity_new')->default(0)->comment('จำนวนสินค้าที่เติม');
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
        Schema::dropIfExists('system_product_quantity');
    }
};
