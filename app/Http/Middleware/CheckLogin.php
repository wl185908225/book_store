<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin 
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
        $http_referer = $_SERVER['HTTP_REFERER'];

        $member = \Request::get('member', '');
        if(empty($member))
        {
            return redirect('/login?return_url=' . urlencode($http_referer));
        }

        return $next($request);
    }
}
