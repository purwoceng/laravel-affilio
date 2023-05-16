<?php

namespace App\Repositories\City;

use App\Models\ApiCity;
use App\Repositories\Interfaces\City\CityRepositoryInterface;

class CityRepository implements CityRepositoryInterface {

    public function getCities($limit = 20 , $start = 0, $name = '')
    {
        $data = ApiCity::where('city_name', 'like', '%' . $name . '%')->offset($start)->limit($limit)->get();
        if($data){
            $results = [];
            foreach ($data as $city){
                $results[] = [
                    'id' => $city->city_id,
                    'name' => $city->city_name,
                    'text' => $city->type
                ];
            }

            return $results;
        }

        return [];
    }
}
