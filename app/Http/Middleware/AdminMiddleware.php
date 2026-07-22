<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user instanceof User || ! in_array($user->role, ['superadmin', 'organizer'], true)) {
            abort(403, 'Anda tidak memiliki akses ke area ini.');
        }

        if ($user->role === 'organizer' && ! $user->organization_id) {
            abort(403, 'Akun organizer belum terhubung ke organisasi.');
        }

        return $next($request);
    }
}
