<?php

namespace Tests\Unit;

use Tests\TestCase;

class WeatherHelper extends TestCase
{
    
    public array $result = [
        "weather" => [
            "coord" => [
                "lon" => 10.99,
                "lat" => 44.34
            ],
            "weather" => [
                [
                    "id" => 501,
                    "main" => "Rain",
                    "description" => "moderate rain",
                    "icon" => "10d"
                ]
            ],
            "base" => "stations",
            "main" => [
                "temp" => 298.48,
                "feels_like" => 298.74,
                "temp_min" => 297.56,
                "temp_max" => 300.05,
                "pressure" => 1015,
                "humidity" => 64,
                "sea_level" => 1015,
                "grnd_level" => 933
            ],
            "visibility" => 10000,
            "wind" => [
                "speed" => 0.62,
                "deg" => 349,
                "gust" => 1.18
            ],
            "rain" => [
                "1h" => 3.16
            ],
            "clouds" => [
                "all" => 100
            ],
            "dt" => 1661870592,
            "sys" => [
                "type" => 2,
                "id" => 2075663,
                "country" => "IT",
                "sunrise" => 1661834187,
                "sunset" => 1661882248
            ],
            "timezone" => 7200,
            "id" => 3163858,
            "name" => "Zocca",
            "cod" => 200
        ],
        "status" => true
    ];

    public function testCanfetchWeatherForUsers()
    {
        $weatherResult = $this->result;
        $fields = [
            'coord', 'weather', 'base', 'main', 'visibility', 'wind',
            'rain', 'clouds', 'dt', 'sys', 'timezone', 'id', 'name', 'cod',
        ];

        $this->assertTrue($weatherResult['status']);

        foreach ($fields as $field) {

            $this->assertArrayHasKey($field, (array) $weatherResult['weather']);
        }
    }


    public function testCannotfetchWeatherForUsers()
    {
        $weatherResult = [
            'status' => false,
            'weather' => null
        ];
        
        $this->assertNull($weatherResult['weather']);
        $this->assertFalse($weatherResult['status']);
    }
}
