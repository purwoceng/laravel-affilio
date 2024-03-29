<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FunnelLink extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'funnelings';

    protected $fillable = [
        'id',
        'type',
        'url',
        'description',
        'image',
        'is_active',
        'timer',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];
}
