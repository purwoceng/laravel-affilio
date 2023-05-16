<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiCity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'api_city';

    protected $fillable = [
        'province_id',
        'city_id',
        'city_name',
        'type',
        'postal_code'
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];
}
