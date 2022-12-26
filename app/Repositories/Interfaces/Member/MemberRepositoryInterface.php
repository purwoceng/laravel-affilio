<?php

namespace App\Repositories\Interfaces\Member;

interface MemberRepositoryInterface
{
    public function getMemberActive($limit, $start);

    public function getCountMemberActive();

    public function getDataTable($request);

    public function getDataById($id);

    
}
