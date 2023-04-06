<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeatherData($orderBy, $order, $limit = null)
    {
        $url = "http://rainy.section-inf.ch/api/weather?orderBy=$orderBy&order=$order";

        $url .= $limit ? "&limit=$limit" : '';

        $response = Http::get($url);

        return $response->json();
    }

    public function getWeatherBetweenDates($start, $end, $orderBy, $order, $limit = null)
    {
        $url = "http://rainy.section-inf.ch/api/weather/dates?start=$start&end=$end&orderBy=$orderBy&order=$order";

        $url .= $limit ? "&limit=$limit" : '';

        $response = Http::get($url);
        
        return $response->json();
    }

    public function getLatestWeather()
    {
        $response = Http::get("http://rainy.section-inf.ch/api/weather/latest");
        return $response->json();
    }

    public function getWeatherSpecificDate($year, $month, $day)
    {
        $response = Http::get("http://rainy.section-inf.ch/api/weather/$year/$month/$day");
        return $response->json();
    }

    
}