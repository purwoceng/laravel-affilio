<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'banners';

    protected $fillable = [
        'id',
        'banner_category_id',
        'name',
        'image',
        'target_url',
        'description',
        'path',
        'path_url',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function category_type()
{
    return $this->belongsTo( BannerCategory::class, 'banner_category_id');
}
}
