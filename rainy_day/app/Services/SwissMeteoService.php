<?php

namespace App\Services;

use App\Services\WeatherService;

class SwissMeteoService
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getAverageWeatherData($orderBy, $order, $limit = null)
    {
        // Récupération des données météorologiques à partir de l'API
        $weatherData = $this->weatherService->getWeatherData($orderBy, $order, $limit);

        // Calcul de la moyenne des valeurs reçues
        $sum = 0;
        $count = 0;
        foreach ($weatherData as $data) {
            if (isset($data['value'])) {
                $sum += $data['value'];
                $count++;
            }
        }
        $average = ($count > 0) ? ($sum / $count) : 0;

        return $average;
    }
}