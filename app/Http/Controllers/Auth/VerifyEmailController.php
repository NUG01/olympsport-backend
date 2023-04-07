<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::where('email', $request->email)->where('verification_code', $request->code)->first();

        if ($user && $user->email_verified_at === null) {
            $user->markEmailAsVerified();
            Auth::login($user);

            return response()->json('Email verified!');
        }

        if ($user && $user->email_verified_at) {
            return response()->json('Email is already verified!', 400);
        }

        return response()->json('Something went wrong', 400);
    }
}
