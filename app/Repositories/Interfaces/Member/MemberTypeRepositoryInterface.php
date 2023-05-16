<?php

namespace App\Repositories\Interfaces\Member;

interface MemberTypeRepositoryInterface
{
    public function getMemberType($limit, $start);

    public function getCountMemberType();

    public function getDataTable($request);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getDataById($id);

    public function getDownline($member_id, $generation = 1, $limit = 10, $offset = 0, $founder_id = 0);
}
