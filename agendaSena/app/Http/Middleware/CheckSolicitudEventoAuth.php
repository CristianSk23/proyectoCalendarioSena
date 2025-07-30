<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSolicitudEventoAuth
{
     public function handle(Request $request, Closure $next)
    {
        if (!session('solicitud_autenticada')) {
            return redirect()->route('mostrar.modal.solicitud');
        }

        return $next($request);
    }
}
