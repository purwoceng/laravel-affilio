<?php

namespace App\Repositories\Interfaces\Member;

interface MemberRepositoryInterface
{
    public function getMemberActive($limit, $start);

    public function getCountMemberActive();

    public function getDataTable($request);

    public function getDataById($id);

    public function getDownline($member_id, $generation = 1, $limit = 10, $offset = 0, $founder_id = 0);
}
