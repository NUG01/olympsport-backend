<?php

namespace App\Services;

use App\Http\Resources\Admin\UserResource;
use App\Models\Subscription;
use App\Models\User;
use Stripe\StripeClient;

class UserService
{
    public function get(User $user): UserResource
    {
        $dates= '';
        $intervals = '';
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $stripeId = Subscription::where('user_id', $user->id)->get();

        if ($user->stripe_id != null) {
            $intervals = $stripe->subscriptions->retrieve(
                $stripeId[0]['stripe_id'],
                []
            );
            if ($intervals['cancel_at_period_end'] === false) {
                $dates = $stripe->invoices->upcoming([
                    'customer' => $user->stripe_id,
                ]);
            }
        }

        $user->extra = (object)['intervals' => $intervals, 'dates' => $dates];

        return UserResource::make($user);
    }
}
