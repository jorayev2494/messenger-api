<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Foundation\Configuration\Middleware;

readonly class Kernel
{
    public static function handle(Middleware $middleware): void
    {
        /** @see https://benjamincrozat.com/customize-middleware-laravel-11 **/
        $middleware->redirectGuestsTo(static fn (): null => null);
    }
}