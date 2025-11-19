<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function fetch(Request $request)
    {
        $countryId = $request->input('country_id');
        $stateId = $request->input('state_id');

        if ($countryId) {
            $states = DB::table('states')
                        ->where('country_id', $countryId)
                        ->get();

            return response()->json($states);
        }

        if ($stateId) {
            $cities = DB::table('cities')
                        ->where('state_id', $stateId)
                        ->get();

            return response()->json($cities);
        }

        $countries = DB::table('countries')->get();
        return response()->json($countries);
    }
}
