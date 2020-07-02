<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Vérifie que l'utilisateur authentifié possède un rôlr spécifique
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user()->hasRole($role)){
            abort(403, trans("This action is unauthorized."));
        }
        return $next($request);
    }
}
