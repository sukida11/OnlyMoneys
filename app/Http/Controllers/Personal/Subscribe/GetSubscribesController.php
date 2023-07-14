<?php

namespace App\Http\Controllers\Personal\Subscribe;

use App\Http\Controllers\Controller;
use App\Http\Resources\Person\PersonResource;
use Illuminate\Http\Request;

class GetSubscribesController extends Controller
{
    public function __invoke()
    {

        return PersonResource::collection(auth()->user()->subscribe_on);

    }
}
