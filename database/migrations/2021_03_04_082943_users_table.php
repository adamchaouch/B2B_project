<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 255);
            $table->string('password', 255);
            ////////
            $table->integer('role_id')->nullable();
            $table->integer('supplier_id')->nullable();
            ///////
            $table->integer('phone_num1')->nullable();
            $table->integer('phone_num2')->nullable();
            $table->integer('tax_number')->nullable();
            $table->string('first_resp_name')->nullable();
            $table->string('adress')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->integer('postal_code')->nullable();
            $table->boolean('validation')->default(0);
            $table->boolean('product_visibility')->nullable();

            //logistic fileds
            $table->boolean('logistic_service')->default(false);
            $table->float('lat')->nullable();
            $table->float('long')->nullable();
            ///add img min price
            $table->string('img_url')->nullable();
            $table->string('img_name')->nullable();
            $table->string('description')->nullable();
            $table->float('min_price')->default(0);
            ///latitude  longitude
            $table->decimal('latitude', 17, 13)->nullable();
            $table->decimal('longitude', 17, 13)->nullable();
            ///cover
            $table->string('cover_img_url')->nullable();
            $table->string('cover_img_name')->nullable();
            //token
            $table->longText('token')->nullable();

            // Schema declaration
            // Constraints declaration

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');

    }
}
