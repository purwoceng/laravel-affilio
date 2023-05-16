<?php

namespace App\Repositories\Interfaces\City;

interface CityRepositoryInterface {
    public function getCities($limit, $start, $name);
}
