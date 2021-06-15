<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
\Illuminate\Session\Middleware\StartSession::class;
\Illuminate\View\Middleware\ShareErrorsFromSession::class;

class CheckAdmin
{

    public $ROLE_OPERATOR = 'LOJA_OPERADOR';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $roles = $request->user()->roles;

            if($roles->contains('name', $this->ROLE_OPERATOR)){
                if (Auth::guard($guard)->check()) {
                    Auth::logout();
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['email' => 'Sem permissão para acessar essa área']);
                }
            }
        }



        return $next($request);
    }
}
