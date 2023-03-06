<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserWeather;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
              ->count(20)
              ->has(UserWeather::factory()->count(1), 'weather')
              ->create();
    }
}