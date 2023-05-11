<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberNetworkTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_generations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('member_id');
            $table->text('networks');
            $table->timestamps();
        });

        Schema::create('member_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('member_id');
            $table->unsignedTinyInteger('generation');
            $table->unsignedInteger('member_upline_id');
            $table->text('networks');
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
        Schema::dropIfExists('member_generations');
        Schema::dropIfExists('member_positions');
    }
}
