<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLocationOwnerOrAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // admin => accès total
        if ($user->is_admin) {
            return $next($request);
        }

        // récupérer location si elle existe dans la route
        $location = $request->route('location');

        if ($location && $location->user_id !== $user->id) {
            abort(403, 'Action non autorisée');
        }

        return $next($request);
    }
}
