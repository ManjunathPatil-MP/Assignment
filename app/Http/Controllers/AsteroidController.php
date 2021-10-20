<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class AsteroidController extends Controller
{
    public function Asteroid()
    {
        return view('/Asteroid');
    }
    public function GetAsteroid(Request $Request)
    {
        $Data = $Request->input();
        $httpClient = new \GuzzleHttp\Client();
        $request =
            $httpClient
                ->get("https://api.nasa.gov/neo/rest/v1/feed?start_date=${Data['StartDate']}&end_date=${Data['EndDate']}&api_key=ISisDHujn9j6M3Ee2qtk6xq4f52wOGO7zu4szZbG");
        $response = json_decode($request->getBody()->getContents());

        $DataArr = json_decode(json_encode($response->near_earth_objects), true);
        $NumberOfAsteroids = array();
        $NumberOfDates = array();
        $kilometers_per_hour = array();
        $ClosestDistance = array();
        $EstimatedDiameterMax = array();

        foreach($DataArr as $key1=>$value1){
            array_push($NumberOfAsteroids,count($value1));
            array_push($NumberOfDates,$key1);
            foreach($value1 as $key2=>$value2){
                foreach($value2['close_approach_data'] as $key3=>$value3){
                    $kilometers_per_hour += [$value2['id'] => $value3['relative_velocity']['kilometers_per_hour']];
                    $ClosestDistance += [$value2['id'] => $value3['miss_distance']['kilometers']];
                }
                foreach($value2['estimated_diameter'] as $key4=>$value4){
                    $EstimatedDiameterMax += [$value2['id'] => $value4['estimated_diameter_max']];
                }
            }
        }
        //Average Size of the Asteroids in kilometers
        $AverageSize = array_sum($EstimatedDiameterMax)/count($EstimatedDiameterMax);

        //Fastest Asteroid in km/h (Respective Asteroid ID & its speed)
        $FastestAsteroidValue = max($kilometers_per_hour);
        $FastestAsteroidID = array_keys($kilometers_per_hour, max($kilometers_per_hour));

        //Closest Asteroid (Respective Asteroid ID & its distance)
        $ClosestAsteroidValue = min($ClosestDistance);
        $ClosestAsteroidID = array_keys($ClosestDistance, min($ClosestDistance));

        return view('Asteroid',['FastestAsteroidValue' => $FastestAsteroidValue,
        'FastestAsteroidID' => $FastestAsteroidID,
        'ClosestAsteroidValue' => $ClosestAsteroidValue,
        'ClosestAsteroidID' => $ClosestAsteroidID,
        'AverageSize' => $AverageSize,
        'NumberOfDates' =>$NumberOfDates,
        'NumberOfAsteroids' => $NumberOfAsteroids]);
    }
}
