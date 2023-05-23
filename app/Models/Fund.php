<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;

    protected $table = 'funds';

    protected $fillable = [
        'id',
        'username',
        'email',
        'status',
        'code',
        'title',
        'value',
        'status_transfer',
        'status_verify',
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
