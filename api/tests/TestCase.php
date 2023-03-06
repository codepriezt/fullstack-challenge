<?php

namespace Tests;


use App\Services\Contracts\WeatherServiceInterface;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Mock\MockWeatherService;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    public function mockweatherService()
    {
        $mock = new MockWeatherService();
        $this->app->instance(WeatherServiceInterface::class, $mock);
        return $mock;
    }
}
