<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    protected $table = 'funds';

    protected $fillable = [
        'id',
        'username',
        'email',
        'code',
        'title',
        'description',
        'value',
        'status_transfer',
        'is_active',
        'publish',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
