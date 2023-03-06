<?php

namespace App\Repository;

use App\Models\User;
use App\Models\UserWeather;
use App\Repository\Contracts\WeatherRepositoryInterface;

class WeatherRepository implements WeatherRepositoryInterface
{

    public function fetch(array $data)
    {
        $builder = User::select(['id', 'name', 'email', 'latitude', 'longitude' ]);

        if ($data['search']) {
            $builder->whereLike(['name', 'email'], $data['search']);
        }
        return $builder->paginate($data['pageSize']);
    }

    public function createOrUpdate(array $data, int $userId)
    {
        return UserWeather::updateOrCreate(
            [
                'user_id' => $userId
            ],
            [
                'user_id' => $userId,
                'weather' => $data['weather'][0]['main'],
                'weather_description' => $data['weather'][0]['description'],
                'base' => $data['base'],
                'temp' => $data['main']['temp'],
                'main_temp_min' => $data['main']['temp_min'],
                'main_temp_max' => $data['main']['temp_max'],
                'main_pressure' => $data['main']['pressure'],
                'main_humidity' => $data['main']['humidity'],
                'main_sea_level' => $data['main']['sea_level'],
                'main_grnd_level' => $data['main']['grnd_level'],
                'visibility' => $data['visibility'],
                'wind_speed'  => $data['wind']['speed'],
                'wind_deg' => $data['wind']['deg'],
                'wind_gust' => $data['wind']['gust'],
                'sys_sunrise' => $data['sys']['sunrise'],
                'sys_sunset' => $data['sys']['sunset'],
                'timezone' => $data['timezone']
            ]
        );
    }

    public function fetchUserCords($page, $limit)
    {
        $offset = ($page - 1) * $limit;
        return User::selectRaw("id, latitude, longitude")
            ->orderBy('id')
            ->offset($offset)
            ->limit($limit)
            ->cursor();
    }
}
