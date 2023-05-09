<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoTraining extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'video_trainings';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'member_type_id',
        'name',
        'url',
        'image',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];
}
