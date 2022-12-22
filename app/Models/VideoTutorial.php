<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoTutorial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'video_tutorials';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'member_type_id',
        'name',
        'url',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];
}
