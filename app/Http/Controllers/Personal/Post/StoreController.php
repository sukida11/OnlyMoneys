<?php

namespace App\Http\Controllers\Personal\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personal\Post\StoreRequest;
use App\Models\Post;
use App\Models\PostImage;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            $user = auth()->user();
            $data['user_id'] = $user->id;
            $images = $data['images'] ?? false;
            unset($data['images']);

            $post = Post::create($data);

            if($images)
            {
                foreach ($images as $image)
                {
                    $timeForName = strtotime(Carbon::now());
                    $fileName = $timeForName . '_' . $image->hashName();

                    $file = Storage::disk('public')->putFileAs('content/', $image, $fileName);

                    PostImage::create([
                        'path' => $file,
                        'url' => url('/storage/' . $file),
                        'post_id' => $post->id
                    ]);

                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return \response()->json($e);
        }


        return redirect()->route('personal.index');

    }
}
