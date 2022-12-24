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
        Schema::create('system_thread_type', function (Blueprint $table) {
            $table->id();
            $table->string('thread_type_name')->nullable()->comment('ชื่อประเภท');
            $table->integer('thread_type_count')->default(0)->comment('จำนวนรายการในหัวข้อนี้');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
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
        Schema::dropIfExists('system_thread_type');
    }
};
