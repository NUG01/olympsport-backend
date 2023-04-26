<?php

namespace App\Http\Middleware;

use App\enums\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role === Role::ADMIN->value) {
                return $next($request);
            }
        }

        abort(404);
    }
}
