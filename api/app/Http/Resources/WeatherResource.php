<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'weather' => $this->weather,
            'weather_description' => $this->weather_description,
            'base' => $this->base,
            'temp' => $this->temp,
            'main_temp_min' => $this->main_temp_min,
            'main_temp_max' => $this->main_temp_max,
            'main_pressure' => $this->main_pressure,
            'main_humidity' => $this->main_humidity,
            'main_sea_level' => $this->main_sea_level,
            'main_grnd_level' => $this->main_grnd_level,
            'visibility' => $this->visibility,
            'wind_speed'  => $this->wind_speed,
            'wind_deg' => $this->wind_deg,
            'wind_gust' => $this->wind_gust,
            'sys_sunrise' => $this->sys_sunrise,
            'sys_sunset' => $this->sys_sunset,
            'timezone' => $this->timezone
        ];
    }
}
