<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductHome extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_home';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id',
        'type',
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
