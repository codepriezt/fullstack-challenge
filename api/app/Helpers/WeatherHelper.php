<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class WeatherHelper
{

    public static function fetchWeatherReport($item)
    {
        try {
            $query = http_build_query([
                'lat' => $item['lat'],
                'lon' => $item['long'],
                'appid' => config('weather.WEATHER_SERVICE_KEY')
            ]);

            $url = config('weather.WEATHER_SERVICE_URL') . $query;

            $response = Http::get($url);
    
            if ($response->successful()) {
                return [
                    'weather' => $response->collect()->toArray(),
                    'status' => true
                ];
            }

            if ($response->serverError() || $response->failed() || $response->clientError()) {
                return  [
                    'weather' => null,
                    'status' => false
                ];
            }
        } catch (\Exception $e) {
            Log::error('Error::FetchingWeatherFromThirdParty' . '=>' . $e->getMessage(), $e->getTrace());
            return false;
        }
    }
}
