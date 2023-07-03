<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Models\User;

class VerifEmail extends Controller
{
    public function __invoke()
    {

        $user = auth()->user();

        if(!$user->email_verified_at){
            $user->sendEmailVerificationNotification();
        }

        return redirect()->route('verification.notice');

    }
}
