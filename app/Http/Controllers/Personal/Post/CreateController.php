<?php

namespace App\Http\Controllers\Personal\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;

class CreateController extends Controller
{
    public function __invoke()
    {

        return view('personal.post.create', ['post_status' => serialize(Post::getPostStatus())]);

    }
}
