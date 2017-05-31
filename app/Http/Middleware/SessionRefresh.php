<?php

namespace App\Http\Middleware;

use Closure;

class SessionRefresh
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
        $message = session('message');
        $messageType = session('messageType');

        session()->regenerate();

        session([
            'message' => $message,
            'messageType' => $messageType
        ]);

        return $next($request);
    }
}
