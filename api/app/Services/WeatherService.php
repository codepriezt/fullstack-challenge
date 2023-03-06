<?php

namespace App\Services;

use App\Models\User;
use App\Helpers\WeatherHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\Contracts\WeatherServiceInterface;
use App\Repository\Contracts\WeatherRepositoryInterface;


class WeatherService implements WeatherServiceInterface
{
    protected $weatherRepo;

    public function __construct(WeatherRepositoryInterface $weatherRepository)
    {
        $this->weatherRepo = $weatherRepository;
    }

    public function fetchUserWeathers()
    {
        try {

            $pageSize =  request()->has('pageSize') ? request()->input('pageSize') : 15;
            $search = request()->input('search');

            return $this->weatherRepo->fetch(['search' => $search, 'pageSize' => $pageSize]);
        } catch (\Exception $e) {
            Log::error('FetchUser::Error' . '=>' . $e->getMessage(), $e->getTrace());
            throw $e;
        }
    }

    public function updateWeathersDetails(int $page, int $limit, int $totalPage)
    {
        try {

            DB::beginTransaction();

            $users = $this->weatherRepo->fetchUserCords($page, $limit);
            if (count($users) >= 1) {
                foreach ($users as $user) {
                    $cordinates = ['lat' => $user->latitude, 'long' => $user->longitude];
                    $weatherResult = WeatherHelper::fetchWeatherReport($cordinates);

                    if ($weatherResult['status']) {
                        $this->weatherRepo->createOrUpdate($weatherResult['weather'], $user->id);
                        Log::info('Success::Updated User =>' . $user->id . "Weather Report");
                    } else {
                        Log::error('Error::Unable to updated User =>' . $user->id . "Weather Report");
                    }
                }
                DB::commit();
            }
            return true;
        } catch (\Exception $e) {
            Log::error('Error::UpdatingUserCurrentWeather' . '=>' . $e->getMessage(), $e->getTrace());
            return false;
        }
    }
}
