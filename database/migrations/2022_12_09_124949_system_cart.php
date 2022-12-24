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
        Schema::create('system_cart', function (Blueprint $table) {
            $table->id();
            $table->integer('cart_person_id')->default(0)->comment('รหัสสมาชิก');
            $table->integer('cart_person_type')->default(0)->comment('0=member,1=buyer');
            $table->integer('cart_product_id')->default(0)->comment('รหัสสินค้า');
            $table->integer('cart_product_quantity')->default(0)->comment('จำนวนสินค้า');
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
        Schema::dropIfExists('system_cart');
    }
};
