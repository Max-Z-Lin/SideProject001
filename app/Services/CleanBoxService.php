<?php

namespace App\Services;

use App\CleanBox;

class CleanBoxService
{
    public function createCleanBox($request_arr)
    {
        $result = CleanBox::create([
            'region' => $request_arr['region'],
            'road' => $request_arr['road'],
            'location' => $request_arr['location'],
            'latitude' => $request_arr['latitude'],
            'longitude' => $request_arr['longitude'],
            'remarks' => $request_arr['remarks']
        ]);

        return $result;
    }
}
