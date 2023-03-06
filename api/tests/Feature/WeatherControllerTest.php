<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class WeatherControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public $weatherService;

    const WEATHER_BASE_URL = 'v1/users';


    /**
     * Test for weather fetching
     */

    public function testCanFetchWeathers()
    {
        $this->seed(UserSeeder::class);
        $response = $this->getJson(self::WEATHER_BASE_URL);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' =>  __('messages.users_fetched_successfully'),
                'status' => true
            ]);
    }
}
