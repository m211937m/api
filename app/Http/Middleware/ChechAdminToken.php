<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use GuzzleHttp\ClientTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class ChechAdminToken
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = null;
        try{
            $user = JWTAuth::parseToken()->authenticate();
        }
        catch(\Exception $e){
            return $this->returnError('1', $e->getMessage());
        }
        catch(\Throwable $e){
            return $this->returnError('1', $e->getMessage());
        }
        if(!$user){
            $this->returnError('undefind','S001');
        }

        return $next($request);
    }
}
