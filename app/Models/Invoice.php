<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'id',
        'browser_id',
        'code',
        'payment_code',
        'payment_method',
        'payment_token',
        'notification_history',
        'member_id',
        'username',
        'type',
        'discount',
        'subtotal',
        'fee',
        'shipping_cost',
        'total',
        'description',
        'status',
        'name',
        'no_wa',
        'email',
        'date_created',
        'date_expired',
        'date_process',
        'date_paid',
        'date_canceled',
        'cancel_reason'
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
