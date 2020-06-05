<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class CheckAccountCompleted
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
        // return $next($request);
        $user = User::find(Auth::user()->id);
        if ($user->account_completed) {
          return $next($request);
        }
        return redirect()->route('complete');
    }
}
