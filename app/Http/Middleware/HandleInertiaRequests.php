<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'locale' => app()->getLocale(),
            'availableLocales' => ['en', 'de', 'tr', 'es', 'ar', 'pt', 'fr', 'it', 'nl'],
            'localizedUrls' => $this->buildLocalizedUrls($request),
        ];
    }

    private function buildLocalizedUrls(Request $request): array
    {
        $supported = ['en', 'de', 'tr', 'es', 'ar', 'pt', 'fr', 'it', 'nl'];
        $path = ltrim($request->path(), '/');

        // Detect if the current path has a locale prefix (exact match or followed by '/')
        $currentLocale = null;
        foreach ($supported as $loc) {
            if ($path === $loc || str_starts_with($path, $loc . '/')) {
                $currentLocale = $loc;
                break;
            }
        }

        return Collection::make($supported)->mapWithKeys(function ($l) use ($currentLocale, $path) {
            if ($currentLocale !== null) {
                // Locale-prefixed route: swap the locale prefix
                $remainder = substr($path, strlen($currentLocale));
                return [$l => '/' . $l . $remainder];
            }

            // Non-locale-prefixed route: keep the same path, use query param to set locale
            return [$l => '/' . $path . '?locale=' . $l];
        })->all();
    }
}
