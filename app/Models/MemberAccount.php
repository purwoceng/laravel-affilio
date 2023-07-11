<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAccount extends Model
{
    use HasFactory;

    protected $table = 'banks';

    protected $fillable = [
        'id',
        'member_id',
        'username',
        'bank_name',
        'account_number',
        'account_name',
        'publish',
        'is_deleted',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
