<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'orders_product';
    protected $fillable = [
        'id',
        'product_id',
        'order_id',
        'product_name',
        'product_image',
        'original_price',
        'price',
        'weight',
        'amount',
        'total_original_price',
        'total',
        'markup_price',
        'selling_price',
        'profit',
        'profit_affiliator',
        'profit_baleomol',
        'total_profit',
        'total_profit_affiliator',
        'total_profit_baleomol',
        'total_weight',
        'commision',
        'options',
        'fee',

    ];

    protected $casts = [
        'date_created'  => 'datetime:Y-m-d H:i:s',
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function orders()
    {
        return $this->belongsTo(Order::class,'id','order_id');
    }
}
