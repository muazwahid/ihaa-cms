<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAdminLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pull the language from your GeneralSettings
        $settings = app(\App\Settings\GeneralSettings::class);
        app()->setLocale($settings->site_language);

        return $next($request);
    }
}
