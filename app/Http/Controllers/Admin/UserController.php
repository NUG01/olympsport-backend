<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }

    public function update(EditUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->noContent();
    }

    public function setStatus(Request $request)
    {
        $user = User::find($request->id);
        $verified = $user->email_verified_at;
        $verified ?  $user->email_verified_at = null : $user->email_verified_at = now();
        $user->save();
        return response()->noContent();
    }

    public function searchCities(Request $request)
    {
        $cities = City::where('city_name', 'like',  $request->city_name . '%')->get(['id', 'city_name']);
        return response()->json($cities);
    }

    public function getCity(City $city)
    {
        return response()->json($city);
    }

    public function editPassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => ['required',  'min:6', 'current_password:sanctum'],
            'password_confirmation' => ['required', 'same:current_password'],
            'new_password' => ['required', 'min:6'],
        ]);

        Auth::user()->update([
            'password' => bcrypt($validatedData['new_password'])
        ]);
        return response()->noContent();
    }
}
