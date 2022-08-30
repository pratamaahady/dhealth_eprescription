<?php

namespace App\Http\Controllers;

use App\Http\COntrollers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ]);

        if(! Auth::check()){
            return response()->error('Username / Password anda salah.')->setStatusCode(422);
        }

        $user = Auth::user();
        $user->createPersonalAccessToken();

        return response()->success('Berhasil login.', $user);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->success('Berhasil logout.')->setStatusCode(204);
    }
}
