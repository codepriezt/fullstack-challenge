<?php

namespace App\Repository;

use App\Models\User;
use App\Models\UserWeather;
use App\Repository\Contracts\WeatherRepositoryInterface;
use Illuminate\Support\Facades\DB;

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
        try {

            DB::beginTransaction();

            $weather = isset($data['weather'][0]['main']) ? $data['weather'][0]['main'] : null;
            $weatherDescription = isset($data['weather'][0]['description']) ?
                $data['weather'][0]['description'] : null;
            $base = isset($data['base'])  ? $data['base'] : null;
            $temp = isset($data['main']['temp']) ? $data['main']['temp'] : null;

            UserWeather::updateOrCreate(
                [
                    'user_id' => $userId
                ],
                [
                    'user_id' => $userId,
                    'weather' => $weather,
                    'weather_description' => $weatherDescription,
                    'base' =>  $base,
                    'temp' => $temp,
                    'main_temp_min' => $data['main']['temp_min']  ?? null,
                    'main_temp_max' => $data['main']['temp_max'] ?? null,
                    'main_pressure' => $data['main']['pressure'] ?? null,
                    'main_humidity' => $data['main']['humidity'] ?? null,
                    'main_sea_level' => $data['main']['sea_level'] ?? null,
                    'main_grnd_level' => $data['main']['grnd_level'] ?? null,
                    'visibility' => $data['visibility'],
                    'wind_speed'  => $data['wind']['speed']  ?? null,
                    'wind_deg' =>   $data['wind']['deg'] ?? null,
                    'wind_gust' =>  $data['wind']['gust'] ?? null,
                    'sys_sunrise' =>  $data['sys']['sunrise'] ?? null,
                    'sys_sunset' =>  $data['sys']['sunset'] ?? null,
                    'timezone' =>  $data['timezone'] ?? null
                ]
            );
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
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
