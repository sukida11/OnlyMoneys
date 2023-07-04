<?php

namespace App\Http\Resources\Person\Image;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageContentResource extends JsonResource
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
            'name' => 'post_content_image_name',
            'size' => 12345,
            'url' => $this->url
        ];
    }
}
