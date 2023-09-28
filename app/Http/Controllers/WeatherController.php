<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RakibDevs\Weather\Weather;
use Illuminate\Support\Facades\Http;
use App\Models\City;

class WeatherController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function getDetails(Request $request)
    {
        $wt = new Weather();
        $apiKey = '4b6c741631b1783bb42158cefbd9c9f1';
        $cityName = $request->city;
        // Make the API request
        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $cityName,
            'appid' => $apiKey,
        ]);
        $errorMessage = '';
        if ($response->successful()) {
            } else {
                $errorMessage =  $errorMessage = "City '{$cityName}' not found.";
            }

        if($errorMessage == '')
        {
            $info = $wt->getCurrentByCity($cityName);
            City::create(['city_name'=> $cityName]);
            return view('details', compact('cityName', 'info'));
        }else{
            return redirect()->back()->with('errorMessage', $errorMessage);
        }

    }
}
