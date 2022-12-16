<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'id',
        'code',
        'payment_code',
        'payment_method',
        'member_id',
        'type',
        'username',
        'subtotal',
        'fee_midtrans',
        'shipping_cost',
        'total',
        'description',
        'status',
        'whatsapp_number',
        'date_expired',
        'date_process',
        'date_paid',
        'date_canceled',
        'cancel_reason',
        'publish',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'published_at' => 'datetime:Y-m-d H:i:s',
    ];
}
