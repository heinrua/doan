<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if (!$user) {
            return response()->view('pages.errors.403', [
                'message' => 'Bạn chưa đăng nhập vào trang chủ.',
            ], 403);
        }

        if ($user->is_master) {
            return $next($request);
        }

        if (!$user->hasPermission($permission)) {
            return response()->view('pages.errors.403', [
                'message' => 'Bạn không có quyền truy cập trang này.',
            ], 403);        }

        return $next($request);
    }
}
