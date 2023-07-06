<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\Person\Post\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(User $user)
    {
        $count_content = $_GET['count_content'] ?? Post::COUNT_CONTENT_PER_PAGE;

        return PostResource::collection(
            Post::latest()
                ->where('user_id', $user->id)
                ->offset((int)$count_content - Post::COUNT_CONTENT_PER_PAGE)
                ->limit(Post::COUNT_CONTENT_PER_PAGE)
                ->get()
        );
    }

}
