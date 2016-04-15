<?php namespace Shine\Http\Middleware; 

use Closure;
use ShineOS\Core\API\Entities\ApiUserAccount;
use Illuminate\Http\JsonResponse;

        
class apiauth {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $api_key = $request->header('ShineKey');
        $api_secret = $request->header('ShineSecret');

        if(!empty($api_key) AND !empty($api_secret)) {
            $result = ApiUserAccount::where('api_key',$api_key)->where('api_secret',$api_secret)->first();
            if(!is_null($result)) {
                return $next($request);
            }
        }
        return new JsonResponse(array('message'=>'Unauthorized Access'), 401);
    }
}
