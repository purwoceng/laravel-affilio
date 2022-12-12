<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64);
            $table->integer('payment_code');
            $table->enum('payment_method', ['midtrans'])->nullable();
            $table->unsignedBigInteger('member_id');
            $table->enum('type', ['order'])->nullable();
            $table->string('username', 50);
            $table->integer('subtotal')->default('0');
            $table->integer('fee_midtrans')->default('0');
            $table->integer('shipping_cost')->default('0');
            $table->integer('total')->default('0');
            $table->longText('description');
            $table->enum('status',['unpaid','confirm','pending','paid','cancel','refund']);
            $table->string('whatsapp_number', 32)->nullable();
            $table->dateTime('date_expired')->nullable()->default(null);
            $table->dateTime('date_process')->nullable()->default(null);
            $table->dateTime('date_paid')->nullable()->default(null);
            $table->dateTime('date_canceled')->nullable()->default(null);
            $table->string('cancel_reason', 255)->nullable()->default(null);
            $table->enum('publish', ['0','1'])->default('0');
            $table->timestamps();
            $table->timestamp('published_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
