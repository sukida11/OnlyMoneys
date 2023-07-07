<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Person\PersonResource;
use App\Models\User;

class FindPersonController extends Controller
{
    public function __invoke()
    {

        $usernameForFind = $_GET['username'] ?? false;

        if ($usernameForFind) {
            $result = User::where('username', 'like', "%$usernameForFind%")
                ->where('username', '!=', auth()->user()->username)
                ->get();

            if (count($result) < 1) $result = "Никто не был найден! Попробуйте снова!";

            if(!is_string($result)) return PersonResource::collection($result);

            return response()->json(['message' => $result]);
        }

    }
}
