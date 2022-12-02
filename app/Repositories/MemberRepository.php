<?php

namespace App\Repositories;

use App\Models\Member;
use App\Repositories\Interfaces\MemberRepositoryInterface;

class MemberRepository implements MemberRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getMemberActive()
    {
        return Member::where('is_blocked','0')->where('publish','1')->get();
    }

    public function getMemberBlocked()
    {
        return Member::where('is_blocked','1')->where('publish','1')->get();
    }
}
