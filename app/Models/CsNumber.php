<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CsNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cs_numbers';

    protected $fillable = [
        'id',
        'cs_category_id',
        'number',
        'name',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function category_type()
    {
        return $this->belongsTo(CsNumberCategory::class, 'cs_category_id')->withTrashed();
    }
}
