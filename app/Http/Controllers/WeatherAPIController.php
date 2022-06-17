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

        $response = $this->GetWeatherDataFromAPI($CityName);

        //Check if response is successful (not a server error)
        if(!$response->serverError()) {

            //Return data back to view
            $JSON = $response->json();
            return view('app')-> with('WeatherData', $JSON);

        } else {

            //Return with server error
            return view('app')->with('APIError', 'An error has occured, please try again later');

        }
    
    }


    //Function to call API and return response data
    static function GetWeatherDataFromAPI($CityName) {

        //Get API key depending on environment
        if(ENV('APP_ENV') == 'local') {
            $APIKey = ENV('OPENWEATHER_API_KEY_LOCAL');

        } else if(ENV('APP_ENV') == 'testing') {
            $APIKey = ENV('OPENWEATHER_API_KEY_TESTING');

        } else if(ENV('APP_ENV') == 'production') {
            $APIKey = ENV('OPENWEATHER_API_KEY_PROD');

        } else {
            //Environment is set to something unrecognised, default to local key
            $APIKey = ENV('OPENWEATHER_API_KEY_LOCAL');
        }
           
        //Name validated, make request to API
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather?q='.$CityName.',GB&appid='.$APIKey.'&units=metric');

        return $response;

    }

}
