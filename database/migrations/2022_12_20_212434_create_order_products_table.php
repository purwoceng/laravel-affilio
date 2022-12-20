<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('origin_product_id');
            $table->string('product_name', 191);
            $table->integer('price_markup');
            $table->integer('quantity');
            $table->integer('origin_price');
            $table->integer('origin_total_price');
            $table->integer('price');
            $table->integer('total_price');
            $table->json('variant')->nullable();
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
        Schema::dropIfExists('order_products');
    }
}
