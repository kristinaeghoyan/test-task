<?php

namespace App\Http\Middleware;

use App\RequestHistory;
use Closure;

class LogRequests
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
        RequestHistory::store($request);
        return $next($request);
    }
}
