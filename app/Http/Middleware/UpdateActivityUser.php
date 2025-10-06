<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UpdateActivityUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id_user;
            // simpan waktu
            Cache::put('user-is-online-' . $userId, true, now()->addMinutes(5));
            Cache::put('user-last-seen-' . $userId, now(), now()->addDays(7));

            Log::info('User Activity', [
                'user_id' => $user->id_user,
                'name' => $user->name,
                'time' => now()->toDateTimeString(),
            ]);
        }

        return $next($request);
    }
}
