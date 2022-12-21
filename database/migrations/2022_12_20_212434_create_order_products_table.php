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
            $table->string('product_name', 256);
            $table->integer('quantity');
            $table->integer('weight');
            $table->integer('total_weight');
            $table->integer('price_markup');
            $table->integer('total_price_markup');
            $table->integer('origin_price');
            $table->integer('origin_total_price');
            $table->integer('price');
            $table->integer('total_price');
            $table->integer('profit')->default('0');
            $table->integer('total_profit')->default('0');
            $table->foreignId('variant_id')->nullable();
            $table->string('variant_name',128)->nullable();
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
