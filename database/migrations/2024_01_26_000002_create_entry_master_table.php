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
        Schema::create('entry_master', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('product_id')->default(1)->comment('default 1 = tea');
            $table->integer('quantity')->default(0);
            $table->datetime('entry_time');
            $table->softDeletes();
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
        Schema::dropIfExists('entry_master');
    }
};
