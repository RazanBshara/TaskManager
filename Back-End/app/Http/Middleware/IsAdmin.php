<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\RoleGroup;
use App\Models\UserRoleGroup;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //1
        $userid =  auth()->user()->id;
        
        $rolegroupid = UserRoleGroup::where('userid' , '=' , $userid)->min('rolegroupid');

        $rolegroup = RoleGroup::where('id' , '=' , $rolegroupid)->first();

        if ($rolegroup->adjictive == 'Administrator' || $rolegroup->adjictive == 'Super Admin') {
            return $next($request);
        }else {
            return response('Not Allowed (Not Admin)');
        }

        
    }
}
