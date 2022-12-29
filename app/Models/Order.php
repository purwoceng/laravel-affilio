<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'id',
        'member_id',
        'origin_order_id',
        'origin_order_code',
        'origin_invoice_id',
        'origin_invoice_code',
        'order_code',
        'invoice_code',
        'name',
        'waybill_number',
        'shipping_cost',
        'price_product',
        'total',
        'phone',
        'province_id',
        'city_id',
        'subdisctrict_id',
        'address',
        'note',
        'postal_code',
        'status',
        'payment_status',
        'unique_code',
        'shipping_courier',
        'shipping_service',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'cancel_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];
}
