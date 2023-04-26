<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Stripe;

class SubscriptionController extends Controller
{
    public function userIntent(Request $request): JsonResponse
    {
        $request->user()->paymentMethods();
        $intent = $request->user()->createSetupIntent();

        return response()->json(['data' => $intent]);
    }

    public function subscribe(Request $request): Response
    {
        $request->validate([
            'holderName' => 'required|string',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = $request->user();
        $paymentMethod = $request->paymentMethod;
        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
        $subscription = $user->newSubscription($request->plan_id, $request->stripe_plan);
        $subscription->create($paymentMethod, [
            'email' => $user->email,
        ]);

        return response()->noContent();
    }
}
