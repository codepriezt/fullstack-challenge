<?php

namespace App\Providers;

use App\Repository\Contracts\WeatherRepositoryInterface;
use App\Services\Contracts\WeatherServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\WeatherService;
use App\Repository\WeatherRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        WeatherServiceInterface::class => WeatherService::class,
        WeatherRepositoryInterface::class => WeatherRepository::class
    ];


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        // bind the repositories
        foreach ($this->bindings as $interface => $concreteClass) {
            $this->app->bind($interface, $concreteClass);
        }
    }
}
