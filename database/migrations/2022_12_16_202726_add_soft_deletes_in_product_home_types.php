<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesInProductHomeTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_home_types', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('supplier_home_types', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_home_types', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('supplier_home_types', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
