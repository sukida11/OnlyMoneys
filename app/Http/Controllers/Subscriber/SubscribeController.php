<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function __invoke(User $user)
    {

        auth()->user()->subscribe_on()->toggle($user->id);
        return response()->json(['data' => auth()->user()->subscribe_on]);

    }
}
