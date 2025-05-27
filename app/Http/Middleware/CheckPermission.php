<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::user()->hasRole($role)) {
            return redirect()->route('login'); // Chuyển hướng đến trang đăng nhập nếu không có vai trò
        }

        return $next($request);
    }
}