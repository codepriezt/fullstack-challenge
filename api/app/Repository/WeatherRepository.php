<?php

namespace App\Repository;

use App\Models\User;
use App\Models\UserWeather;
use App\Repository\Contracts\WeatherRepositoryInterface;

class WeatherRepository implements WeatherRepositoryInterface
{

    public function fetch(array $data)
    {
        $builder = User::select(['id', 'name', 'email', 'latitude', 'longitude']);

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
                
                'weather' => array_key_exists($data['weather'][0]['main'], $data) ? $data['weather'][0]['main'] : null,

                'weather_description' => array_key_exists($data['weather'][0]['description'], $data) ?

                    $data['weather'][0]['description'] :  null,
                'base' => array_key_exists($data['base'], $data) ? $data['base'] :  null,

                'temp' => array_key_exists($data['main']['temp'], $data) ?  $data['main']['temp'] : null,

                'main_temp_min' => array_key_exists($data['main']['temp_min'], $data)
                    ? $data['main']['temp_min'] : null,

                'main_temp_max' => array_key_exists($data['main']['temp_max'], $data) ?
                    $data['main']['temp_max'] : null,

                'main_pressure' => array_key_exists($data['main']['pressure'], $data)
                    ? $data['main']['pressure'] : null,

                'main_humidity' => array_key_exists($data['main']['humidity'], $data)
                    ? $data['main']['humidity'] : null,

                'main_sea_level' => array_key_exists($data['main']['sea_level'], $data)
                    ? $data['main']['sea_level'] : null,

                'main_grnd_level' => array_key_exists($data['main']['grnd_level'], $data)
                    ? $data['main']['grnd_level'] : null,

                'visibility' => array_key_exists($data['visibility'], $data)
                    ? $data['visibility'] : null,

                'wind_speed'  => array_key_exists($data['wind']['speed'], $data)
                    ? $data['wind']['speed'] : null,

                'wind_deg' => array_key_exists($data['wind']['deg'], $data) ? $data['wind']['deg'] : null,

                'wind_gust' => array_key_exists($data['wind']['gust'], $data) ? $data['wind']['gust'] : null,

                'sys_sunrise' => array_key_exists($data['sys']['sunrise'], $data) ? $data['sys']['sunrise'] : null,

                'sys_sunset' => array_key_exists($data['sys']['sunset'], $data) ? $data['sys']['sunset'] : null,

                'timezone' => array_key_exists($data['timezone'], $data) ? $data['timezone'] : null
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
