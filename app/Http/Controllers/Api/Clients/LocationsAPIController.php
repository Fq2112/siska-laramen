<?php

namespace App\Http\Controllers\Api\Clients;

use App\Cities;
use App\Provinces;
use App\Http\Controllers\Controller;

class LocationsAPIController extends Controller
{
    public function loadProvinces()
    {
        $provinces = Provinces::all()->toArray();
        return $provinces;
    }

    public function loadCities()
    {
        $cities = Cities::all()->toArray();
        return $cities;
    }

    public function loadLocations()
    {
        $cities = $this->loadCities();

        $i = 0;
        foreach ($cities as $city) {
            $province = array('province' => Provinces::find($city['province_id'])->name);

            if (substr($city['name'], 0, 2) == "Ko") {
                $city['name'] = substr($city['name'], 5);
            } else {
                $city['name'] = substr($city['name'], 10);
            }

            $loc[$i] = array_replace($province, $cities[$i], $city);

            $i = $i + 1;
        }
        return $loc;
    }
}
