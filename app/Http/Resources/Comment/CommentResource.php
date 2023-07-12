<?php

namespace App\Http\Resources\Comment;

use App\Models\PostComment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'username' => $this->user->username,
            'answers' => $this::collection(PostComment::where('comment_id', $this->id)->get()),
            'is_comment' => $this->comment_id === null
        ];
    }
}
