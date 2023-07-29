<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PushNotification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'push_notifications';

    protected $fillable = [
        'id',
        'title',
        'description',
        'url',
    ];

    protected $casts = [
        'created_at' => 'datetime: H:i:s d-m-Y',
        'updated_at' => 'datetime: H:i:s d-m-Y',
        'deleted_at' => 'datetime: H:i:s d-m-Y',
    ];
}
