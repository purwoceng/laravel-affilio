<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInactivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_inactives', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('origin_product_id');
            $table->unsignedInteger('origin_supplier_id');
            $table->string('origin_supplier_username', 64);
            $table->string('name', 64);
            $table->string('image_url', 200);
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
        Schema::dropIfExists('product_inactives');
    }
}
