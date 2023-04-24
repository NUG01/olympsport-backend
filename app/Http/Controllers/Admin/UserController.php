<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function get(User $user)
    {
        return response()->json($user);
    }

    public function update(EditUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->noContent();
    }

    public function setStatus(User $user)
    {
        $verified = $user->email_verified_at;
        $verified ?  $user->email_verified_at = null : $user->email_verified_at = now();
        $user->save();
        return response()->noContent();
    }
}
