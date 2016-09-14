<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponWorkerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_worker', function (Blueprint $table) {
        $table->integer('coupon_id')->unsigned()->nullable();
        $table->foreign('coupon_id')
            ->references('id')->on('coupons')
            ->onDelete('cascade');
        $table->integer('worker_id')->unsigned()->nullable();
        $table->foreign('worker_id')
            ->references('id')->on('workers')
            ->onDelete('cascade');
        $table->string('year');
        $table->string('month');
        $table->date('date');
        $table->string('meal');
        $table->string('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coupon_worker');
    }
}
