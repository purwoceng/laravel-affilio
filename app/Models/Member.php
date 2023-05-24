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
        'is_founder',
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
        'is_transaction'
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

    public function funds()
    {
        return $this->belongsTo(Fund::class, 'member_id', 'id');
    }
    public function withdraw()
    {
        return $this->belongsTo(Withdraw::class, 'member_id', 'id');
    }
}
