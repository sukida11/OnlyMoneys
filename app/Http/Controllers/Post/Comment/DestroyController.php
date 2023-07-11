<?php

namespace App\Http\Controllers\Post\Comment;

use App\Http\Controllers\Controller;
use App\Models\PostComment;
use Illuminate\Http\Request;

class DestroyController extends Controller
{
    public function __invoke(PostComment $comment)
    {

        $comment->delete();
        return response()->json(['message' => 'deleted successful']);

    }
}
