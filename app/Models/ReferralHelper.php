<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReferralHelper extends Model
{
    use HasFactory;
    protected $table = 'referral_helper';
    protected $fillable = ['member_id', 'member_is_founder', 'member_username', 'member_type_id','referral_id','referral_is_founder','referral_username','referral_type_id'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id')->withTrashed();
    }
}
