<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierNonActive extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'supplier_inactives';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'origin_supplier_id',
        'username',
        'store_name',
        'image_url',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];
}
