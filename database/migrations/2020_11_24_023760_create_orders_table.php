<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            // TODO: Add Products
            $table->integer('quantity');
            // TODO: $table->float('total'); // Or decimal?
            $table->boolean('fulfilled')->default(FALSE);
            $table->timestamps();

            // Foreign keys
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('address_id');

            $table->foreign('user_id')->references('id')->on('users'); // TODO: How do you drop a foreign key?
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
