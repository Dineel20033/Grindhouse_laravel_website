<?php
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    // ...

    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // ⭐ NEW: Check if the request is trying to access an Admin route
        if ($request->routeIs('admin.*')) {
            // Redirect to the new custom Admin login route
            return route('admin.login');
        }

        // Default redirect for regular users
        return route('login');
    }
}