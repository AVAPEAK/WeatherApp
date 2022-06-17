<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\WeatherAPIController;

class GetWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetWeather {city_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets the weather of the given city, if valid';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $City = $this->argument('city_name');
        
        $response = WeatherAPIController::GetWeatherDataFromAPI($City);

        //Check if response is successful (not a server error)
        if(!$response->serverError()) {

            //Return data back to view
            $JSON = $response->json();
            
            $out = new \Symfony\Component\Console\Output\ConsoleOutput();

            $out->writeln("Temperature: ".$JSON['main']['temp']);
            $out->writeln("Feels Like: ".$JSON['main']['feels_like']);
            $out->writeln("Max: ".$JSON['main']['temp_max']);
            $out->writeln("Min: ".$JSON['main']['temp_min']);
            $out->writeln("Humidity: ".$JSON['main']['humidity']);
            $out->writeln("Weather: ".$JSON['weather'][0]['main']);
            $out->writeln("Weather: ".$JSON['weather'][0]['description']);
            if(isset($JSON['wind']['speed'])) {
                $out->writeln("Wind Speed: ".$JSON['wind']['speed']);
            }
            if(isset($JSON['rain']['1h'])) {
                $out->writeln("Rain Volume (last hour): ".$JSON['rain']['1h']);
            }

            return 0;

        } else {

            //Return with server error
            return 'APIError: An error has occured, please try again later';

        }


        return 0;
    }
}
