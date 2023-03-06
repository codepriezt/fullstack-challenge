<?php

namespace App\Services\Contracts;

interface WeatherServiceInterface
{
    public function fetchUserWeathers();

    public  function updateWeathersDetails(int $page, int $limit, int $totalPage);
}
