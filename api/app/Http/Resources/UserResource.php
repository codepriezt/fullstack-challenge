<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\WeatherResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'name' => ucwords($this->name),
            'email' => $this->email,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'weather' => new WeatherResource($this->weather)

        ];
    }
}
