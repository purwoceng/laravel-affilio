<?php

namespace App\Models;

use App\Models\MemberAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'id',
        'chat_user_id',
        'username',
        'email',
        'member_type_id',
        'hash',
        'phone',
        'name',
        'image',
        'referral',
        'is_verified',
        'publish',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function member_type()
    {
        return $this->belongsTo(MemberType::class, 'member_type_id', 'id')->withTrashed();
    }

    public function member_addresses()
    {
        return $this->belongsTo(MemberAddress::class, 'id', 'member_id');
    }
}
