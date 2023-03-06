<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\Contracts\WeatherServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;


class ProcessWeatherUpdate implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * The current time before the job kicks in
     */
    public $time;

    /**
     * The Weather Service
     */
    public $weatherService;

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 3600;


    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;


   
    /**
     * The number of seconds to wait before retrying the job. .
     *
     * @var int
     */
    public $backoff = 3;


    /**
     * The unique ID of the job.
     */
    public function uniqueId(): string
    {
        return $this->time = now();
    }

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
