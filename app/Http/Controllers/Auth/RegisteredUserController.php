<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'city' => ['required', 'integer'],
            'address' => ['sometimes'],
            'phone_number' => ['required'],
//            'avatar' => ['sometimes'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $avatar = '/avatars/default.png';

        if ($request->file('avatar')) $avatar = $request->file('avatar')->store('avatars');

        $token = sha1(time());
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'city' => $request->city,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
//            'avatar' => $avatar,
            'verification_code' => $token,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            $url = config('app.frontend_url') . '/email-confirmation/' . 'email=' . $user->email . '&token=' . $token;
            MailController::sendVerificationEmail($user->name, $user->email, $url);
            return response()->json('Email sent!');
        }

        return response()->json('Email can not be sent!');
    }
}
