<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Laravel\Cashier\Subscription;

class ProfileController extends Controller
{
    public function user(UserService $service, User $user): UserResource
    {
        return $service->get($user);
    }

    public function update(ProfileRequest $request, User $user): Response
    {
        $user->update($request->validated());

        return response()->noContent();
    }

    public function products(User $user): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::with(['user', 'photos', 'categories'])->whereIn('id', $user->product_id)->get());
    }

    public function cancelSubscription(UserService $service, User $user): ?Subscription
    {
        return $service->cancelSubscription($user);
    }

    public function destroy(UserService $service, User $user): Response
    {
        $service->cancelSubscription($user);
        $user->delete();

        return response()->noContent();
    }
}
