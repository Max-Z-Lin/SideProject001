<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CleanBoxService;

class CleanBoxController extends Controller
{
    protected $cleanBoxService;

    public function __construct(CleanBoxService $cleanBoxService)
    {
        $this->cleanBoxService = $cleanBoxService;
    }

    public function postCleanBox(Request $request)
    {
        $request_arr = [];

        $request_arr['region'] = $request->get('region');
        $request_arr['road'] = $request->get('road');
        $request_arr['location'] = $request->get('location');
        $request_arr['latitude'] = $request->get('latitude');
        $request_arr['longitude'] = $request->get('longitude');
        $request_arr['remarks'] = $request->get('remarks');

        $data = $this->cleanBoxService->createCleanBox($request_arr);

        return response()->json(['data' => $data]);

    }
}
