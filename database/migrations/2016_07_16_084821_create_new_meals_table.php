<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_meals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('construction_site_id')->unsigned();
            $table->integer('coupon_id')->unsigned();
            $table->integer('worker_id')->unsigned();
            $table->string('meal');
            $table->foreign('construction_site_id')
                  ->references('id')->on('construction_sites')
                  ->onDelete('cascade');
            $table->foreign('coupon_id')
                  ->references('id')->on('coupons')
                  ->onDelete('cascade');
            $table->foreign('worker_id')
                  ->references('id')->on('workers')
                  ->onDelete('cascade');
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
        Schema::drop('new_meals');
    }
}
