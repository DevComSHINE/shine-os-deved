<?php
namespace Shine\Http\Middleware;

use Closure, Cache, Session;

class AccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module)
    {
        //if (Cache::has('roles')) {
        if (Session::has('roles')) {
            //$val = Cache::get('roles');
            $val = Session::get('roles');

            if ( (isset($val['modules'][$module])) OR (isset($val['external_modules'][$module])) OR ($val['role_name'] == 'Developer') )// for dev edition only
            {
                return $next($request);
            }
            else
            {
                Session::flash('warning', 'You are not authorized to access the page.');
                return redirect('dashboard');
            }
        } else {
            return redirect('logout/111');
        }
    }
}
