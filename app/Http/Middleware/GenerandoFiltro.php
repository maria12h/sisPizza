<?php

namespace sisVentas\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class GenerandoFiltro
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
        $url=$request->url();

        if(!(Session::has('idUsuario')) && $url!='http://127.0.0.1:8000' && !($request->has('correo')))
        {
          return redirect('/');
        }
        $response = $next($request);

        //after request

        return $response;
    }
}