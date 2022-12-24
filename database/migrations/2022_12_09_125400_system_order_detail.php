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
        Schema::create('system_order_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('order_detail_main')->default(0)->comment('ไอดีออเดอร์');
            $table->integer('order_detail_product')->default(0)->comment('ไอดีสินค้า');
            $table->integer('order_detail_quantity')->default(0)->comment('จำนวนสินค้า');
            $table->float('order_detail_price')->default(0)->comment('ราคาสินค้าต่อชิ้น');
            $table->float('order_detail_point')->default(0)->comment('คะแนนสินค้าต่อชิ้น');
            $table->float('order_detail_freight')->default(0)->comment('ค่าขนส่งสินค้าต่อชิ้น');
            $table->integer('order_detail_review')->default(0)->comment('รีวิวสินค้า');
            $table->float('order_detail_etc')->default(0)->comment('ค่าพิเศษ');
            $table->float('order_detail_etc2')->default(0)->comment('ค่าพิเศษ 2');
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
        Schema::dropIfExists('system_order_detail');
    }
};
