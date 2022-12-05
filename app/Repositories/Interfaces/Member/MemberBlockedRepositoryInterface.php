<?php

namespace App\Repositories\Interfaces\Member;

interface MemberBlockedRepositoryInterface
{
    public function getMemberBlocked($limit, $start);

    public function getCountMemberBlocked();

    public function getDataTable($request);
}
