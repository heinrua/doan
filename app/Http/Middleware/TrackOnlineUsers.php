<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackOnlineUsers
{
    
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip(); 
        $expiresAt = now()->addMinutes(5);

        Cache::put('user-online-' . $ip, true, $expiresAt);

        return $next($request);
    }
}
