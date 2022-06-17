<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class WeatherAPIController extends Controller
{
    
    function WeatherSearch(Request $request) {
        
        //Validate name has been passed in request
        $this->validate($request, [
            'city' => 'required|max:255',
        ]);

        $CityName = $request->city;
        $APIKey = ENV('OPENWEATHER_API_KEY');

        //Name validated, make request to API
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather?q='.$CityName.'&appid='.$APIKey.'&units=metric');
        $JSON = $response->json();

        //Return data back to view
        return view('app')-> with('WeatherData', $JSON);
        
    }

}
