<?php

namespace Database\Factories;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserWeatherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'weather' => 'sunny',
            'weather_description' => 'The weather sunny',
            'base' =>  'stations',
            'temp' => 45.78,
            'main_temp_min' => 45.78,
            'main_temp_max' => 45.78,
            'main_pressure' => 45,
            'main_humidity' => 70,
            'main_sea_level' => 89,
            'main_grnd_level' => 67,
            'visibility' => 48,
            'wind_speed'  => 67.98,
            'wind_deg' =>   89.00,
            'wind_gust' =>  56.09,
            'sys_sunrise' =>  5,
            'sys_sunset' => 3,
            'timezone' =>  56
        ];
    }
}
