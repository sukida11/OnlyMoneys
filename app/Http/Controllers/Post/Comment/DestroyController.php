<?php

namespace App\Http\Controllers\Post\Comment;

use App\Http\Controllers\Controller;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestroyController extends Controller
{
    public function __invoke(PostComment $comment)
    {

        $firstCondition = $comment->user->id === auth()->user()->id;
        $secondCondition = $comment->post->user->id === auth()->user()->id;

        if($firstCondition || $secondCondition)
        {
            try {
                DB::beginTransaction();

                $comments = PostComment::where('comment_id', $comment->id)->get();

                foreach ($comments as $comm)
                {
                    $comm->delete();
                }

                $comment->delete();
                DB::commit();
                return response()->json(['message' => 'deleted successful']);
            } catch (\Exception $e) {
                DB::rollBack();
            }

        }



    }
}
