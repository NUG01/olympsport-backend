<?php

namespace App\Http\Resources\Admin;

use App\Models\City;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'verified' => $this->email_verified_at ? true : false,
            'subscription' => $this->when($this->stripe_id !== null, function () use ($request) {
                if ($request->routeIs('admin.users.get') && $request->user()->stripe_id !== null) {
                    $plan = User::findOrFail($this->id)->subscriptions()->get()[0]['stripe_price'];
                    $canceled_at = $this->extra->intervals['plan']['cancel_at_period_end'];
                    if ($canceled_at === null || $canceled_at === false) {
                        foreach ($this->extra->dates['lines']['data'] as $item) {
                            return [
                                'intervals' => [
                                    'start_date' => Carbon::createFromTimestamp($this->extra->intervals['created'])->format('d/m/Y'),
                                    'next_payment' => Carbon::createFromTimestamp($item['period']['start'])->format('d/m/Y'),
                                ],
                                'period' => ucfirst($this->extra->intervals['plan']['interval']),
                                'name' => User::findOrFail($this->id)->subscriptions()->get()[0]['name'],
                                'cost' => Plan::where('stripe_plan', $plan)->value('cost') . ' CHF',
                            ];
                        }
                    } else {
                        return [
                            'intervals' => [
                                'started_date' => Carbon::createFromTimestamp($this->extra->intervals['created'])->format('d/m/Y'),
                                'cancel_time' => Carbon::createFromTimestamp($this->extra->intervals['canceled_at'])->format('d/m/Y')
                            ],
                            'period' => ucfirst($this->extra->intervals['plan']['interval']),
                            'name' => User::findOrFail($this->id)->subscriptions()->get()[0]['name'],
                            'cost' => Plan::where('stripe_plan', $plan)->value('cost') . ' CHF',
                        ];
                    }
                }
            })
        ];
    }
}
