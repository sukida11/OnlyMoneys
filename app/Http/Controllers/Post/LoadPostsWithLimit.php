<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\Person\Post\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class LoadPostsWithLimit extends Controller
{
    public function __invoke(User $user)
    {
        $limit = $_GET['limit'] ?? Post::COUNT_CONTENT_PER_PAGE;


        if (isset($_GET['main']) && $_GET['main'] === 'true')
        {
            return PostResource::collection(
                Post::latest()
                    ->limit($limit)
                    ->get()
            );
        }

        return PostResource::collection(
            Post::latest()
                ->where('user_id', $user->id)
                ->limit($limit)
                ->get()
        );
    }
}
