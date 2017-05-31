<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;
use App\AccessCode;

class VerifyAccessCode
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
        $result = AccessCode::where('code', $request->accessCode)->first();
        if(empty($result)) {
            return redirect('/vote')->with([
                'message' => config('vote.messages.invalidAccessCode'),
                'messageType' => 'exception'
            ]);
        }

        // Generate and store a token to identify a logged-in user
        $request->session()->put('sessionToken', Hash::make("$request->accessCode:{$request->session()->getId()}"));

        // Store the user's access code
        $request->session()->put('accessCodeId', $result->id);

        return $next($request);
    }
}
