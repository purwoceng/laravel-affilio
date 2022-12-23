<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_products';
    protected $fillable = [
        'id',
        'order_id',
        'origin_product_id',
        'product_name',
        'price_markup',
        'quantity',
        'origin_price',
        'origin_total_price',
        'price',
        'total_price',
        'variant',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
