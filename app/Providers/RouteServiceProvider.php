<?php

namespace App\Providers;

use App\Enums\RoutePattern;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '';

    /** @var array<string, RoutePattern> */
    private const ROUTE_PATTERNS = [
        'id' => RoutePattern::INTEGER,
        'uuid' => RoutePattern::UUID,
    ];

    public function boot(): void
    {
        $this->app->singleton('route.registrar', \Illuminate\Routing\RouteRegistrar::class);
        $this->configureRateLimiting();

        $this->registerRoutePatterns();
        $this->routes(function (): void {
            $this->registerWebRoutes();
            $this->registerWebPDFRoutes();
        });
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
//
//            Route::middleware('web')
//                ->group(base_path('routes/web.php'));
        });
    }

    private function registerWebRoutes(): void
    {
        $this->app->make('route.registrar')
            ->middleware('web')
            ->group(base_path('routes/web.php'));
    }

    private function registerWebPDFRoutes(): void
    {
        if ($this->app->environment(['local'])) {
            $this->app->make('route.registrar')
                ->middleware('web')
                ->group(base_path('routes/pdf.php'));
        }
    }

    private function registerRoutePatterns(): void
    {
        foreach (self::ROUTE_PATTERNS as $key => $pattern) {
            Route::pattern($key, $pattern->value);
        }
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for(
            'api',
            static fn (Request $request): Limit => Limit::perMinute(60 * 3)->by($request->user()?->id ?: $request->ip())
        );
    }
}