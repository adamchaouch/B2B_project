<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductBasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_bases', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_description')->nullable();
            $table->float('taxe_rate');
            $table->integer('category_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('product_package')->nullable();//->after('taxe_rate');
            $table->integer('product_box')->nullable();//->after('product_package');
            $table->string('product_image_url')->nullable();
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
        Schema::dropIfExists('product_bases');
    }
}
