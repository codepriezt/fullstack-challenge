<?php

namespace Tests\Mock;

use App\Models\User;
use Mockery\Mock;
use App\Services\Contracts\WeatherServiceInterface;

class MockWeatherService implements WeatherServiceInterface
{
    protected $items = [
        [
            "id" => 4,
            'name'  => "John Caleb",
            'email' => "test@example.com",
            'latitude' =>  4.68,
            'longitude' => 234.22
        ]
    ];

    public function fetchUserWeathers()
    {
        return new User($this->items);
    }

    public function updateWeathersDetails(int $page, int $limit, int $totalPage)
    {
        return true;
    }
}
