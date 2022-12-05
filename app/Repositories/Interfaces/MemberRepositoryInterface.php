<?php

namespace App\Repositories\Interfaces;

interface MemberRepositoryInterface
{
    public function getMemberActive();

    public function getMemberBlocked();
}
