<?php

namespace App\Http\Controllers\Personal\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\Person\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        $count_content = (int)$_GET['count_content'] ?? Post::COUNT_CONTENT_PER_PAGE;

        return PostResource::collection(Post::latest()->offset($count_content-Post::COUNT_CONTENT_PER_PAGE)->limit(Post::COUNT_CONTENT_PER_PAGE)->get());

    }
}
