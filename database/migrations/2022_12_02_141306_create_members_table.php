<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('member_type_id');
            $table->string('chat_user_id',64)->default('');
            $table->string('username',64);
            $table->string('email',64);
            $table->string('hash',256);
            $table->string('phone',20)->default('');
            $table->string('name',32)->default('');
            $table->string('image',128)->default('');
            $table->string('referral',64)->default('admin');
            $table->tinyInteger('is_verified');
            $table->tinyInteger('is_blocked');
            $table->tinyInteger('publish');
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
        Schema::dropIfExists('members');
    }
}
