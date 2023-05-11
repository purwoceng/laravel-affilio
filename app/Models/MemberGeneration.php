<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberGeneration extends Model
{
    use HasFactory;

    protected $table = 'member_generations';
    protected $fillable = ['member_id', 'networks'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id')->withTrashed();
    }
}
