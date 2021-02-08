<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JsonResponseCamelMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->setContent(collect($response->getOriginalContent())
            ->transformKeys(fn($key) => Str::camel($key))
            ->toJson(JSON_PRETTY_PRINT));

        return $response;
    }
}
