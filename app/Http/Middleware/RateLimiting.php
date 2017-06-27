<?php

namespace App\Http\Middleware;

use App\LoginAttempt;
use Closure;
use Carbon\Carbon;

class RateLimiting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $loginAttempt = LoginAttempt::where('ip_address', $request->ip())->first();

        if (is_null($loginAttempt)) {
            if (!is_null($request->ip())) {
                $loginAttempt = new LoginAttempt;
                $loginAttempt->ip_address = $request->ip();
                $loginAttempt->attempts = 1;
                $loginAttempt->save();
            }
        } else {
            $now = Carbon::now();
            $timeLimit = $loginAttempt->updated_at->addSeconds(config('vote.app.loginAttemptStorageLength'));

            if($now->greaterThan($timeLimit)) {
                $loginAttempt->attempts = 1;
                $loginAttempt->updated_at = (string) $now;
            } else {
                $loginAttempt->attempts++;
            }

            $loginAttempt->save();

            if ($loginAttempt->attempts > config('vote.app.maxLoginAttempts')) {
                return redirect()->route('vote')->with([
                    'message' => config('vote.messages.rateLimited'),
                    'messageType' => 'exception'
                ]);
            }
        }

        return $next($request);
    }
}
