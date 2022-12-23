<?php

namespace App\Repositories\Interfaces\VideoTutorial;

interface VideoTutorialRepositoryInterface
{
    public function getVideoTutorials($limit, $start);

    public function getCountVideoTutorials();

    public function getDataTable($request);
}
