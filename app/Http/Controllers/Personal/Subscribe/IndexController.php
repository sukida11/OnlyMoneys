<?php

namespace App\Http\Controllers\Personal\Subscribe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('personal.subscribe.index', ['subscribing' => auth()->user()->subscribe_on]);
    }
}
