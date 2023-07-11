<?php

namespace App\Http\Controllers\Post\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Models\PostComment;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $comment = PostComment::create([
            'content' => $data['content'],
            'post_id' => $data['post_id'],
            'user_id' => auth()->user()->id
        ]);

        return response()->json(['data' => $comment]);

    }
}
