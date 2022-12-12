<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomePageConfigurationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_home_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('code', 64)->unique();
            $table->timestamps();
        });
        
        Schema::create('supplier_home', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('supplier_id');
            $table->unsignedInteger('supplier_home_type_id');
            $table->string('redis_key');
            $table->unsignedInteger('queue_number');
            $table->enum('is_active', ['0', '1']);
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('product_home_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('code', 64)->unique();
            $table->timestamps();
        });

        Schema::create('product_home', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('product_home_type_id');
            $table->string('redis_key');
            $table->unsignedInteger('queue_number');
            $table->enum('is_active', ['0', '1']);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('home_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('code', 64)->unique();
            $table->timestamps();
        });

        Schema::create('home_configurations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('home_type_id');
            $table->string('title', 64);
            $table->string('redis_key');
            $table->unsignedInteger('queue_number');
            $table->enum('is_active', ['0', '1']);
            $table->timestamps();
        });

        Schema::create('banner_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('code', 64)->unique();
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('banner_category_id');
            $table->string('name', 64);
            $table->string('image');
            $table->string('target_url');
            $table->string('description');
            $table->string('path');
            $table->string('path_url');
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
        Schema::dropIfExists('supplier_home_types');
        Schema::dropIfExists('supplier_home');
        Schema::dropIfExists('product_home_types');
        Schema::dropIfExists('product_home');
        Schema::dropIfExists('home_types');
        Schema::dropIfExists('home_configurations');
    }
}
