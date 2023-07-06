<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __invoke(Post $post)
    {
        auth()->user()->likes()->toggle($post->id);

    }
}
