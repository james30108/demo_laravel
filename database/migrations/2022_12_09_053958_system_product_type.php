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
        Schema::create('system_product_type', function (Blueprint $table) {
            $table->id();
            $table->string('product_type_code')->nullable()->comment('รหัสประเภทสินค้า');
            $table->string('product_type_name')->nullable()->comment('ชื่อประเภทสินค้า');
            $table->text('product_type_detail')->nullable()->comment('รายละเอียด');
            $table->integer('product_type_status')->default(0)->comment('สถานะ');
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
        Schema::dropIfExists('system_product_type');
    }
};
