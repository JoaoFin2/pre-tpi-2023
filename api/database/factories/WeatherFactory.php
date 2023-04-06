<?php

namespace Database\Factories;

use App\Models\Weather;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class WeatherFactory extends Factory
{
    protected $model = Weather::class;

    public function definition()
    {
        return [
            'date' => Carbon::now()->subMonths(4)->toDateString(),
            'precipitation' => $this->faker->numberBetween(0, 100),
            'minTemp' => $this->faker->numberBetween(-20, 35),
            'maxTemp' => $this->faker->numberBetween(-10, 45)
        ];
    }
}
