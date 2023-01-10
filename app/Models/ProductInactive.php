<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInactive extends Model
{
    use HasFactory;
    
    protected $table = 'product_inactives';
    protected $fillable = [
        'origin_product_id',
        'origin_supplier_id',
        'origin_supplier_username',
        'image_url',
        'name',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
