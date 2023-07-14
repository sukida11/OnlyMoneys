<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personal\UpdateRequest;
use App\Models\Avatar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, User $user)
    {
        $data = $request->validated();
        $user = auth()->user();

        $avatar = $data['avatar'] ?? null;
        unset($data['avatar']);

        if($data['email'] !== $user->email)
        {
            $data['email_verified_at'] = null;
        }

        $user->update($data);

        if($user->avatar && $avatar)
        {
            Storage::disk('public')->delete($user->avatar->path);
            Avatar::find($user->avatar->id)->delete();
        }

        if($avatar)
        {
            $time = strtotime(Carbon::now());
            $fileName = $time . "_" . $avatar->hashName();

            $file = Storage::disk('public')->putFileAs('avatars/', $avatar, $fileName);

            Avatar::create([
                'path' => $file,
                'url' => url('/storage/' . $file),
                'user_id' => $user->id
            ]);
        }


        return redirect()->route('personal.index');

    }
}
