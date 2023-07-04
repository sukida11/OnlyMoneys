<?php

namespace App\Http\Controllers\Personal\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personal\Post\UpdateRequest;
use App\Models\Post;
use App\Models\PostImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Post $post)
    {

        $data = $request->validated();
        $user = auth()->user();

        $images = $data['images'] ?? false;
        $delete_images = $data['delete_images'] ?? false;

        unset($data['images'], $data['delete_images']);

        $post->update($data);

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

        if($delete_images)
        {
            foreach ($delete_images as $image_id)
            {
                $image_content = PostImage::find((int)$image_id);

                Storage::disk('public')->delete($image_content->path);

                $image_content->delete();

            }
        }


        return response()->json(['redirect_to' => route('personal.index')]);

    }
}
