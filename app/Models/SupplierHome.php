<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierHome extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'supplier_home';

    protected $fillable = [
        'supplier_id',
        'supplier_home_type_id',
        'redis_key',
        'queue_number',
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
