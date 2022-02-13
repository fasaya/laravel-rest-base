<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AuthenticationException;

class AuthTokenMiddleware
{
	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!auth()->guard('api')->check()){
            return \Response::json(
                [
                    'data' => [
                        'message' => 'Not Authorized.', 
                        'status_code' => 401,
                        'error' => [
                                'message' => (!empty($this->message)) ? $this->message : trans('auth.failed')
                        ]
                    ]
                ],
                401);
        }

        return $next($request);
    }
}
