<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supported_locales = config('app.available_locales', ['en' => 'English']);
        $default_locale = config('app.fallback_locale', 'en');
        $locale = $default_locale;

        $accept_language = $request->header('Accept-Language');
        if ($accept_language) {
            $preferred_locales = explode(',', $accept_language);

            foreach ($preferred_locales as $lang) {
                $lang = strtolower(trim($lang));

                if (str_contains($lang, '-')) {
                    $lang = explode('-', $lang)[0]; // Handle language tags like 'en-US'
                }

                if (array_key_exists($lang, $supported_locales)) {
                    $locale = $lang;
                    break;
                }
            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}
