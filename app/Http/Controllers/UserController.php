<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){
        $users = User::getOrDatatable($request);
        return UserResource::collection($users);
    }

    public function show(User $user, Request $request){
        return new UserResource($user);
    }

    public function store(UserRequest $request){
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->success('Berhasil membuat user.');
    }

    public function update(User $user, UserRequest $request){
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->success('Berhasil mengubah user.');
    }

    public function destroy(User $user, Request $request){
        $user->delete();
        return response()->success('Berhasil menghapus user.');
    }
}
