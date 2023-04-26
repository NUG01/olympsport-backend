<?php

namespace App\Http\Middleware;

use App\enums\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isSeeker
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->role === Role::SEEKER->value) {
                return $next($request);
            }
        }

        abort(404);
    }
}
