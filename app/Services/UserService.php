<?php

namespace App\Services;

use App\Http\Resources\Admin\UserResource;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Subscription as SubscriptionCashier;
use Stripe\StripeClient;

class UserService
{
    public function get(User $user): UserResource
    {
        $dates = '';
        $intervals = '';
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $stripeId = Subscription::where('user_id', $user->id)->get();


        if ($user->stripe_id != null && $stripeId->count() > 0) {
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

    /**
     * @param User $user
     * @return SubscriptionCashier|null
     */
    public function cancelSubscription(User $user): ?SubscriptionCashier
    {
        $subscription = DB::table('subscriptions')->where('stripe_id', $user->id)->first();
        return $user->subscription($subscription->name)->cancel();
    }
}
