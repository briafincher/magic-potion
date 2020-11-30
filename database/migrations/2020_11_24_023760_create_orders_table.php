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
            $table->integer('quantity');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('address_id')->constrained();
            $table->foreignId('payment_method_id')->constrained();
            $table->boolean('fulfilled')->default(false);
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['address_id']);
            $table->dropForeign(['payment_method_id']);
        });
        
        Schema::dropIfExists('orders');
    }
}
