<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    const ROLES = [
       'Admin',
       'Responsable'
    ];
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->user()->userRole()->first()->name, self::ROLES)) {
            return response() -> json([
                'success' => 'error',
                'message' => 'Its not authorized'
            ]);
        }
        return $next($request);
    }
}
