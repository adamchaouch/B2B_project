<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_criteria', function (Blueprint $table) {
            $table->id();
            $table->integer('product_item_id');
            $table->integer('criteria_id');
            $table->integer('criteria_unit_id')->nullable();
            $table->string('criteria_value');
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
        Schema::dropIfExists('items_criteria');
    }
}
