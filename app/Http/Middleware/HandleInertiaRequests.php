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
            'availableLocales' => ['en', 'de', 'tr', 'es'],
            'localizedUrls' => $this->buildLocalizedUrls($request),
        ];
    }

    private function buildLocalizedUrls(Request $request): array
    {
        $locale = app()->getLocale();
        $path   = ltrim($request->path(), '/');

        return Collection::make(['en', 'de', 'tr', 'es'])->mapWithKeys(function ($l) use ($locale, $path) {
            if ($locale !== 'en' && str_starts_with($path, $locale)) {
                $newPath = $l . substr($path, strlen($locale));
            } elseif (str_starts_with($path, 'en')) {
                $newPath = $l . substr($path, 2);
            } else {
                $newPath = $l;
            }

            return [$l => '/' . ltrim($newPath, '/')];
        })->all();
    }
}
