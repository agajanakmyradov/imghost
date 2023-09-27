<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function api() {
        return view('user.api');
    }

    public function changeApi() {
        Auth::user()->update([
            'api_token' => Str::random(32)
        ]);

        return redirect()->route('user.api');

    }
}
