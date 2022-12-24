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
        Schema::create('system_commission', function (Blueprint $table) {
            $table->id();
            $table->string('commission_name')->nullable()->comment('ลำดับชั้น');
            $table->float('commission_point')->default(0)->comment('เปอร์เซ้นต์โบนัส');
            $table->float('commission_point2')->default(0)->comment('เปอร์เซ็นต์โบนัส (พิเศษ)');
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
        Schema::dropIfExists('system_commission');
    }
};
