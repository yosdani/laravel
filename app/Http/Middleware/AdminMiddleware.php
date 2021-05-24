<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->userRole()->first()->id != 1) {
            return response() -> json([
                'success' => 'error',
                'message' => 'Its not authorized'
            ]);
        }
        return $next($request);
    }
}
