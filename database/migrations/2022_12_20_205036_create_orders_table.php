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
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->integer('origin_order_id')->nullable();
            $table->string('origin_order_code',191)->nullable();
            $table->string('waybill_number',64)->nullable();
            $table->integer('origin_invoice_id')->nullable();
            $table->string('origin_invoice_code',191)->nullable();
            $table->string('order_code',191)->nullable();
            $table->unsignedBigInteger('invoice_id');
            $table->string('invoice_code',191)->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->string('supplier_name');
            $table->string('supplier_address');
            $table->string('name',191);
            $table->string('phone',15)->nullable();
            $table->integer('province_id');
            $table->string('province_name',64);
            $table->integer('city_id');
            $table->string('city_name');
            $table->integer('subdistrict_id');
            $table->string('subdistrict_name');
            $table->longText('address')->nullable();
            $table->longText('note')->nullable();
            $table->string('postal_code',16)->nullable();
            $table->enum('status',['unpaid','paid','awaiting_supplier','on_process','on_shipping','received','success','complain','cancel','cancel_but_unpaid']);
            $table->enum('payment_status',['paid','unpaid','cancel']);
            $table->integer('shipping_cost');
            $table->integer('total');
            $table->string('shipping_courier',32);
            $table->string('shipping_service',16);
            $table->timestamps();
            $table->timestamp('cancel_at')->useCurrent();
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
        Schema::dropIfExists('orders');
    }
}
