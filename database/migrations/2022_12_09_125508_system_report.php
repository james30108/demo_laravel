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
        Schema::create('system_report', function (Blueprint $table) {
            $table->id();
            $table->float('report_point')->default(0)->comment('จำนวนรวม');
            $table->integer('report_count')->default(0)->comment('จำนวนรายการรวม');
            $table->integer('report_round')->default(0)->comment('รอบที่');
            $table->integer('report_type')->default(0)->comment('0=default,1=sold,2=withdraw');
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
        Schema::dropIfExists('system_report');
    }
};
