<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED_LOCALES = ['en', 'de', 'tr', 'es'];

    public function handle(Request $request, Closure $next): Response
    {
        // Priority: URL route param > cookie > Accept-Language header > 'en'
        $locale = $request->route('locale');

        if (! in_array($locale, self::SUPPORTED_LOCALES)) {
            $locale = null;
        }

        if (! $locale) {
            $cookie = $request->cookie('locale');
            if (in_array($cookie, self::SUPPORTED_LOCALES)) {
                $locale = $cookie;
            }
        }

        if (! $locale) {
            $preferred = $request->getPreferredLanguage(self::SUPPORTED_LOCALES);
            $locale = in_array($preferred, self::SUPPORTED_LOCALES) ? $preferred : 'en';
        }

        app()->setLocale($locale);

        Cookie::queue('locale', $locale, 60 * 24 * 365, '/', null, false, false);

        return $next($request);
    }
}
