<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_items', function (Blueprint $table) {
            $table->id();
            $table->float('item_online_price')->nullable();
            $table->float('item_offline_price')->nullable();
            $table->integer('item_package')->nullable();
            $table->integer('item_box')->nullable();
            $table->string('item_barcode')->nullable();
            $table->integer('item_warn_quantity')->nullable();
            $table->integer('item_quantity');
            $table->string('item_discount_type')->nullable();
            $table->float('item_discount_price')->nullable();
            $table->bigInteger('product_base_id')->unsigned();
            $table->foreign('product_base_id')->references('id')->on('product_bases')->onDelete('cascade');
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
        Schema::dropIfExists('product_items');
    }
}
