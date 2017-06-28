<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class VerifySession
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
        if(!session()->has('accessCodeId')) {
            return redirect()->route('vote')->with([
                'message' => config('vote.messages.invalidSession'),
                'messageType' => 'exception'
            ]);
        }

        return $next($request);
    }
}
