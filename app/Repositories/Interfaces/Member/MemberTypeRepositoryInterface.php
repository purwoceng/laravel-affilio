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
}
