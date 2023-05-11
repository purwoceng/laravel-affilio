<?php

namespace App\Repositories\Interfaces\Event;

interface EventGreetingRepositoryInterface
{

    public function getGreeting($limit, $start);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getCountGreeting();

    public function getDataTable($request);
}
