<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryStateCitySeeder extends Seeder
{
    public function run(): void
    {
        // Countries
        $indiaId = DB::table('countries')->insertGetId(['name' => 'India']);
        $usaId   = DB::table('countries')->insertGetId(['name' => 'USA']);

        // Indian States and Cities
        $indiaStates = [
            'Maharashtra' => ['Mumbai','Pune','Nagpur','Nashik','Aurangabad'],
            'Karnataka'  => ['Bangalore','Mysore','Mangalore','Hubli','Belgaum'],
            'Tamil Nadu' => ['Chennai','Coimbatore','Madurai','Tiruchirappalli','Salem'],
            'Delhi'      => ['New Delhi','Dwarka','Rohini','Pitampura','Saket']
        ];

        foreach($indiaStates as $state => $cities) {
            $stateId = DB::table('states')->insertGetId([
                'name' => $state,
                'country_id' => $indiaId
            ]);

            foreach($cities as $city) {
                DB::table('cities')->insert([
                    'name' => $city,
                    'state_id' => $stateId
                ]);
            }
        }

        // USA States and Cities (5 cities each)
        $usaStates = [
            'California' => ['Los Angeles','San Francisco','San Diego','San Jose','Sacramento'],
            'Texas'      => ['Houston','Dallas','Austin','San Antonio','Fort Worth'],
            'New York'   => ['New York City','Buffalo','Rochester','Yonkers','Syracuse'],
            'Florida'    => ['Miami','Orlando','Tampa','Jacksonville','Tallahassee']
        ];

        foreach($usaStates as $state => $cities) {
            $stateId = DB::table('states')->insertGetId([
                'name' => $state,
                'country_id' => $usaId
            ]);

            foreach($cities as $city) {
                DB::table('cities')->insert([
                    'name' => $city,
                    'state_id' => $stateId
                ]);
            }
        }
    }
}

