<?php

namespace App\Http\Controllers\Personal\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class GetPostPaidOrFreeController extends Controller
{
    public function __invoke()
    {

        return response()->json(Post::getPostStatus());

    }
}
