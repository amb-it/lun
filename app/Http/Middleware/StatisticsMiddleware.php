<?php

namespace App\Http\Middleware;

use Closure;

class StatisticsMiddleware
{
    public function handle($request, Closure $next)
    {
        if (isset($_COOKIE['statistics'])) {
            \DB::listen(function ($query) {
                dump([
                    $query->sql,
                    $query->bindings,
                    $query->time
                ]);
            });
        }

        $response = $next($request);

        if (isset($_COOKIE['statistics'])) {
            dump('Total execution time - ' . round(microtime(true) - LARAVEL_START, 2) . ' seconds');
        }

        return $response;
    }
}