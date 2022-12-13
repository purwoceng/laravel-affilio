<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHome extends Model
{
    use HasFactory;

    protected $table = 'product_home';

    protected $fillable = [
        'product_id',
        'product_home_type_id',
        'queue_number',
        'redis_key',
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];
}
