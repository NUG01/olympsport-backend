<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\StripeClient;


class PlanController extends Controller
{
    public function subscription(Request $request)
    {
        $stripe = new StripeClient(env('SECRET_KEY'));
//        Stripe::setApiKey(env('SECRET_KEY'));
        $plan = Plan::find($request->plan);
        $subs = Auth::user()->newSubscription($request->plan,$plan->stripe_plan)->create($request->token);
        }
}
