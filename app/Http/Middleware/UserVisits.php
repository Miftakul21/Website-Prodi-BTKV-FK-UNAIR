<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UserVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        DB::table('user_visits')->insert([
            'ip' => $request->ip(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->header('User-Agent'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $next($request);
    }
}
