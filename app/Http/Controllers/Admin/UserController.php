<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\City;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }

    public function get(User $user, UserService $service): UserResource
    {
        return $service->get($user);
    }

    public function destroy(User $user, UserService $service): Response
    {
        $service->cancelSubscription($user);
        $user->delete();
        return response()->noContent();
    }

    public function update(EditUserRequest $request, User $user): Response
    {
        $user->update($request->validated());
        return response()->noContent();
    }

    public function setStatus(Request $request): Response
    {
        $user = User::find($request->id);

        $verified = $user->email_verified_at;
        $verified ? $user->email_verified_at = null : $user->email_verified_at = now();
        $user->save();
        return response()->noContent();
    }

    public function searchCities(Request $request): JsonResponse
    {
        $cities = City::where('city_name', 'like', $request->city_name . '%')->get(['id', 'city_name']);
        return response()->json($cities);
    }

    public function getCity(City $city): JsonResponse
    {
        return response()->json($city);
    }

    public function editPassword(Request $request): Response
    {
        $validatedData = $request->validate([
            'current_password' => ['required', 'min:6', 'current_password:sanctum'],
            'password_confirmation' => ['required', 'same:current_password'],
            'new_password' => ['required', 'min:6'],
        ]);

        Auth::user()->update([
            'password' => bcrypt($validatedData['new_password'])
        ]);
        return response()->noContent();
    }

    public function cancelSubscription(User $user, UserService $service): ?\Laravel\Cashier\Subscription
    {
        return $service->cancelSubscription($user);
    }
}
