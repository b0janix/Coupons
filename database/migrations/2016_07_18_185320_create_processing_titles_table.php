<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessingTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processing_titles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('construction_site_id')->unsigned();
            $table->integer('coupon_id')->unsigned();
            $table->integer('worker_id')->unsigned();
            $table->string('title');
            $table->timestamps();
            $table->foreign('construction_site_id')
                  ->references('id')->on('construction_sites')
                  ->onDelete('cascade');
            $table->foreign('coupon_id')
                  ->references('id')->on('coupons')
                  ->onDelete('cascade');
            $table->foreign('worker_id')
                  ->references('id')->on('workers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('processing_titles');
    }
}
