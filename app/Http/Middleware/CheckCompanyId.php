<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCompanyId
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->company_id == 0) {
            return $next($request);
        }

        abort(403, 'Unauthorized access');
    }
}
