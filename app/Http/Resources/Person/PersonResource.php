<?php

namespace App\Http\Resources\Person;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'avatar' => $this->avatar,
            'username' => $this->username,
            'subscribe' => $this->subscribe_on,
            'subscribers' => Subscriber::where('profile_id', $this->id)->count(),
        ];
    }
}
