<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <title>Weather App</title>
</head>
<body>
    
    <div class="text-center">
        <form action="{{ route('search') }}" method="POST">
            @csrf
            <label for="city">City / Town Name:</label>
            <input id="city" name="city" type="text" placeholder="City Location" required class="p-2 m-3 max-w-3xl border-2 border-black">
            <button class="p-2 border-2 border-black hover:bg-blue-400">
                Search
            </button>
        </form>

        @error('city')
            <div class="text-center bg-red-200 border-red-400 border inline-block pl-2 pr-2 pt-1 pb-1">
                <i class="fa-solid fa-circle-exclamation"></i> Please provide a city or town name
            </div>
        @enderror

    </div>

    @if(isset($WeatherData)) 
        
        <div class="text-center max-w-3xl m-auto border border-blue-200 p-3">
        
            @if($WeatherData['cod'] == 200)
                
                <div class="text-3xl">{{ $WeatherData['name'] }}</div>

                <!-- Main weather data -->
                <div class="text-2xl">
                    {{ $WeatherData['weather'][0]['main'] }}
                </div>

                <div class="text-base text-gray-600">
                    {{ $WeatherData['weather'][0]['description'] }}
                </div>


                <div class="text-3xl m-3 border border-blue-400 inline-block p-4">

                    {{ $WeatherData['main']['temp'] }}&deg;

                    <div class="text-base text-gray-600">
                        Feels like {{ $WeatherData['main']['feels_like'] }}&deg;
                    </div>

                    <div class="text-base text-gray-600">
                        Max Temp. {{ $WeatherData['main']['temp_max'] }}&deg;
                    </div>

                    <div class="text-base text-gray-600">
                        Min Temp. {{ $WeatherData['main']['temp_min'] }}&deg;
                    </div>

                </div>

                <div class="text-2xl m-3">
                    Humidity: {{ $WeatherData['main']['humidity'] }}
                </div>

                @if(isset($WeatherData['wind']['speed']))
                    <div class="text-2xl m-3">
                        Wind Speed: {{ $WeatherData['wind']['speed'] }}
                    </div>
                @endif

                @if(isset($WeatherData['rain']['1h']))
                    <div class="text-2xl m-3">
                        Rain Volume (last hour): {{ $WeatherData['rain']['1h'] }}
                    </div>
                @endif

            @else
                <div class="text-center bg-red-200 border-red-400 border inline-block pl-2 pr-2 pt-1 pb-1">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $WeatherData['message'] }}
                </div>
            @endif

        </div>

    @endif


</body>
</html>