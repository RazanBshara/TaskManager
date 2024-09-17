<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        'taskit_session'    //addeded for solve Session::get and put 
    ];
}

////return config('session.cookie'); show the session.cookie to use it in appove