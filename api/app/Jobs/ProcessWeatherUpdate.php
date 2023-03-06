<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\Contracts\WeatherServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;


class ProcessWeatherUpdate implements ShouldQueue 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $weatherService;


    /**
     * Create a new job instance.
     */
    public function __construct(WeatherServiceInterface $weatherService)
    {
        $this->weatherService =  $weatherService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {

            $limit = 50;
            $totalPages = (int) ceil(User::count() / $limit);

            for ($page = 0; $page < $totalPages; $page++) {
                $this->weatherService->updateWeathersDetails($page, $limit, $totalPages);

                Log::info("Updated Users Weather Page =>" . $page . "in" . $totalPages);
            }
        } catch (\Exception $e) {
            Log::error("Error::Unable To Update Weather for Users of =>" .
                $page . "in" . $totalPages . $e->getMessage());
        }
    }


    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        Log::error("Error::Unable To Update Weather for Users of =>" . $exception->getMessage());
    }
}
