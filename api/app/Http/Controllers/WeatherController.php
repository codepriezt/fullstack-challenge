<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\UserResource;
use App\Http\Resources\DefaultResourceCollection;
use App\Services\Contracts\WeatherServiceInterface as WeatherService;



class WeatherController extends Controller
{
    use ResponseTrait;
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }


    public function fetchUserWeathers()
    {
        try {

            // get  users details for cache
            $url = request()->fullUrl();

            if (Cache::has($url)) {

                // get details from cache
                $users = Cache::get($url);
            } else {
                $users = $this->weatherService->fetchUserWeathers();

                // set details to cache
                Cache::put($url, $users, 300);
            }

            return ResponseTrait::success(
                __('messages.users_fetched_successfully'),
                new DefaultResourceCollection($users, UserResource::class)
            );
        } catch (\Exception $e) {
            return ResponseTrait::error(__("messages.error_occured"), $e);
        }
    }

    public function updateWeatherDetails()
    {
        try {
            $updatedUsers = $this->weatherService->updateWeathersDetails(1, 50, 1);

            if ($updatedUsers) {
                return ResponseTrait::success(__('messages.users_weather_fetched_successfully'));
            }
        } catch (\Exception $e) {
            return ResponseTrait::error(__("messages.error_occured"), $e);
        }
    }
}
