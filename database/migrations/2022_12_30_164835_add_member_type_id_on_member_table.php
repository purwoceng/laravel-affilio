<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemberTypeIdOnMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('members', 'member_type_id')) {
            Schema::table('members', function (Blueprint $table) {
                $table->unsignedInteger('member_type_id')->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('members', 'member_type_id')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('member_type_id');
            });
        }
    }
}
