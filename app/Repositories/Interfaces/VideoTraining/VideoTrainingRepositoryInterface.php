<?php

namespace App\Repositories\Interfaces\VideoTraining;

interface VideoTrainingRepositoryInterface
{
    public function getVideoTraining($limit, $start);

    public function getCountVideoTraining();

    public function getDataTable($request);
}
