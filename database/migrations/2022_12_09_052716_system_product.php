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
        Schema::create('system_product', function (Blueprint $table) {
            $table->id();
            $table->integer('product_type')->default(1)->comment('ประเภทสินค้า');
            $table->integer('product_type2')->default(0)->comment('ประเภทสินค้าพิเศษ');
            $table->string('product_name')->nullable()->comment('ชื่อสินค้า');
            $table->string('product_code')->nullable()->comment('รหัสสินค้า');
            $table->text('product_detail')->nullable()->comment('รายละเอียด');
            $table->float('product_price')->default(0)->comment('ราคาสินค้าสำหรับขายหน้าเว็บ');
            $table->float('product_price_member')->default(0)->comment('ราคาสินค้าสำหรับขายให้สมาชิก');
            $table->float('product_point')->default(0)->comment('คะแนนสินค้า');
            $table->float('product_freight')->default(0)->comment('ค่าขนส่งสินค้า');
            $table->float('product_weight')->default(0)->comment('น้ำหนักสินค้า');
            $table->integer('product_quantity')->default(0)->comment('จำนวนสินค้า');
            $table->string('product_unit')->nullable()->comment('หน่วยสินค้า');
            $table->string('product_group')->nullable()->comment('แพ็กเกจสินค้า');
            $table->integer('product_status')->default(0)->comment('สถานะ');
            $table->float('product_etc')->default(0)->comment('ค่าพิเศษ');
            $table->float('product_etc2')->default(0)->comment('ค่าพิเศษ2');
            $table->string('product_image_cover')->nullable()->comment('รหัสสินค้า');
            $table->string('product_image_1')->nullable()->comment('รูปปกสินค้า');
            $table->string('product_image_2')->nullable()->comment('รูปสินค้า');
            $table->string('product_image_3')->nullable()->comment('รูปสินค้า');
            $table->string('product_image_4')->nullable()->comment('รูปสินค้า');
            $table->string('product_image_5')->nullable()->comment('รูปสินค้า');
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
        Schema::dropIfExists('system_product');
    }
};
