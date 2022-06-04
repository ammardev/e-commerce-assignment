<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Locale;

class LocaleSetter
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->query('lang', 'en');
        Locale::setDefault($locale);

        return $next($request);
    }
}
