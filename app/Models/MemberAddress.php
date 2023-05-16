<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAddress extends Model
{
    use HasFactory;
    protected $table = 'member_addresses';
    protected $fillable = [
        'id',
        'member_id',
        'address',
        'province_name',
        'city_name',
        'main_address',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function members()
    {
        return $this->belongsTo(Member::class,'id','member_id');
    }
}
