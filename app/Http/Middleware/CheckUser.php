<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @param string $role
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $role): Response {
        // This isn't necessary, it should be part of your 'auth' middleware
        if (!Auth::check())
            return redirect('/');

        $user = Auth::user();
        if ($user->user_type === $role)
            return $next($request);

        return redirect('/');
    }
}
