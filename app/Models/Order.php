<?php

namespace App\Models;

use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'id',
        'invoice_code',
        'baleo_invoice_code',
        'member_id',
        'seller_id',
        'seller_store_name',
        'seller_logo',
        'browser_id',
        'code',
        'baleo_order_code',
        'baleo_order_id',
        'username',
        'seller',
        'customer_name',
        'address',
        'zip_code',
        'subdisctrict_id',
        'city_id',
        'province_id',
        'country',
        'phone',
        'email',
        'alternative',
        'resi',
        'resi_desc',
        'message',
        'is_checkout',
        'platform',
        'dropshipper_name',
        'dropshipper_phone',
        'pdf',
        'shipping_courier',
        'shipping_service',
        'shipping_cost',
        'affilio_subtotal',
        'fee',
        'original_value',
        'value',
        'subtotal',
        'total',
        'baleomol_status',
        'status',
        'payment_status',
        'reason_canceled',
        'is_reviewed',
        'from_address',
        'type',
        'no_wa',
        'from_zip_code',
        'from_subdistrict_id',
        'from_city_id',
        'from_province_id',
        'from_latitude',
        'from_longitude',
        'to_latitude',
        'to_longitude',
    ];

    protected $casts = [
        'date_created'  => 'datetime:Y-m-d H:i:s',
        'date_paid' => 'datetime:Y-m-d H:i:s',
        'date_checkout_baleo' => 'datetime:Y-m-d H:i:s',
        'date_confirmed' => 'datetime:Y-m-d H:i:s',
        'date_rejected' => 'datetime:Y-m-d H:i:s',
        'date_waybill_generated' => 'datetime:Y-m-d H:i:s',
        'date_processed' => 'datetime:Y-m-d H:i:s',
        'date_shipped' => 'datetime:Y-m-d H:i:s',
        'date_received' => 'datetime:Y-m-d H:i:s',
        'date_success' => 'datetime:Y-m-d H:i:s',
        'date_disbursed' => 'datetime:Y-m-d H:i:s',
        'date_confirm_expired' => 'datetime:Y-m-d H:i:s',
        'date_process_expired' => 'datetime:Y-m-d H:i:s',
        'date_shipping_expired' => 'datetime:Y-m-d H:i:s',
        'date_success_expired' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'date_last_synced'=> 'datetime:Y-m-d H:i:s'
    ];

    public function order_products()
    {
        return $this->belongsTo(OrderProduct::class, 'id', 'order_id');
    }
}
