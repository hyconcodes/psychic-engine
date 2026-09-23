<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPlan
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->activeSubscription) {
            return redirect()->route('plans.index')
                ->with('toast_message', 'Please activate a plan to access this feature.')
                ->with('toast_variant', 'warning');
        }

        return $next($request);
    }
}
