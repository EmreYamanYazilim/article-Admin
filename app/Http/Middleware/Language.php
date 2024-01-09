<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $defaultLange = "tr";

        $lang = app()->getLocale();
        if ($lang != $defaultLange) {
            app()->setLocale($defaultLange);
        }

        return $next($request);
    }
}
