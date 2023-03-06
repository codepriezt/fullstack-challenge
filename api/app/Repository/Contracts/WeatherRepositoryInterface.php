<?php

namespace App\Repository\Contracts;


interface WeatherRepositoryInterface
{
    public function fetch(array $data);
    public function createOrUpdate(array $data , int $id);
    public function fetchUserCords(int $page, int $limit);
}
