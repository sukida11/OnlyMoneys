<?php

namespace App\Http\Resources\Person\Post;

use App\Http\Resources\Person\Image\ImageContentResource;
use App\Http\Resources\Person\PersonResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'content' => $this->content,
            'images' => ImageContentResource::collection($this->images),
            'user' => new PersonResource($this->user),
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'paid' => $this->paid
        ];
    }
}
