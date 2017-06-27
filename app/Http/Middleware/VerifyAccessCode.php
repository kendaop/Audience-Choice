<?php

namespace App\Http\Middleware;

use App\LoginAttempt;
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
        $result = AccessCode::with('votes')->where('code', $request->accessCode)->first();

        if(empty($result) || (!config('vote.app.allowReVoting') && $result->votes->isNotEmpty())) {
            return redirect()->route('vote')->with([
                'message' => config('vote.messages.invalidAccessCode'),
                'messageType' => 'exception'
            ]);
        }

        // Reset the rate-limiting count for this IP address.
        $loginAttempt = LoginAttempt::find($request->ip());
        $loginAttempt->resetAttempts();

        // Generate and store a token to identify a logged-in user
        $request->session()->put('sessionToken', Hash::make("$request->accessCode:{$request->session()->getId()}"));

        // Store the user's access code
        $request->session()->put('accessCodeId', $result->id);

        return $next($request);
    }
}
