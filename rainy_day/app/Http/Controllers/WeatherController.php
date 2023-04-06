<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;


class WeatherController extends Controller
{
    protected $weatherService;
    protected $display;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index(Request $request) 
    {
        $data = $this->weatherService->getWeatherData('date', 'asc');

        $mostRain = $this->weatherService->getWeatherData('precipitation', 'desc', 3);
        $hottest = $this->weatherService->getWeatherData('maxTemp', 'desc', 3);

        $separateData = $this->separateData($data);

        $this->display = $request->input('display');

        return view('home', array_merge($separateData, [
            'mostRain' => $mostRain,
            'hottest' => $hottest,
            'display' => $this->display
        ], $this->currentWeather()));
    }

    public function chooseDates(Request $request) 
    {
        $from = $request->input('from');
        $to = $request->input('to');
        
        $data = $this->weatherService->getWeatherBetweenDates($from, $to, 'date', 'asc');

        $mostRain = $this->weatherService->getWeatherBetweenDates($from, $to, 'precipitation', 'desc', 3);
        $hottest = $this->weatherService->getWeatherBetweenDates($from, $to, 'maxTemp', 'desc', 3);
        
        $separateData = $this->separateData($data);
        $this->display = $request->input('display');

        return view('home', array_merge($separateData, [
            'from' => $from,
            'to' => $to,
            'mostRain' => $mostRain,
            'hottest' =>$hottest,
            'display' => $this->display
        ], $this->currentWeather()));
    }

    private function separateData($data)
    {
        $dates = array_column($data, 'date');
        $precipitations = array_column($data, 'precipitation');
        $minTemp = array_column($data, 'minTemp');
        $maxTemp = array_column($data, 'maxTemp');

        return [
            'dates' => $dates,
            'precipitations' => $precipitations,
            'minTemp' => $minTemp,
            'maxTemp' => $maxTemp
        ];
    }

    private function currentWeather()
    {
        $current = $this->weatherService->getLatestWeather();
        return [
            'currentDate' => $current['date'],
            'currentTemp' => $current['maxTemp'],
            'currentPrecip' => $current['precipitation']
        ];
    }


    public function details(Request $request, $year, $month, $day)
    {
        $data = $this->weatherService->getWeatherSpecificDate($year, $month, $day);

        $data = $data[0];

        $date = date('d-m-Y', strtotime($data['date']));

        $this->display = $request->input('display');

        return view('details', [
            'date' => $date,
            'minTemp' => $data['minTemp'],
            'maxTemp' => $data['maxTemp'],
            'precipitation' => $data['precipitation'],
            'display' => $this->display
        ]);
    }
}