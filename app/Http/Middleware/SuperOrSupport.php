<?php

namespace App\Http\Middleware;

use Closure;
use Gate;

class SuperOrSupport
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
        if(Gate::denies('super') and Gate::denies('support')) return redirect('/');
        return $next($request);
    }
}
