<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LikedPostsController extends Controller
{
    public function __invoke(User $user)
    {

        $liked_posts = auth()->user()->likes;

        return response()->json(['data' => $liked_posts]);

    }
}
