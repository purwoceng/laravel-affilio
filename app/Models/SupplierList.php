<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierList extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'supplierslist';

    protected $fillable = [
        'id',
        'username',
        'storename',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];
}
