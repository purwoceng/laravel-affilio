<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanaPensiun extends Model
{
    use HasFactory;

    protected $table = 'funds';

    protected $fillable = [
        'id',
        'username',
        'code',
        'title',
        'description',
        'value',
        'status_verify',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];
}
