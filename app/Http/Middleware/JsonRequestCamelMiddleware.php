<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JsonRequestCamelMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $request->request->replace(
                collect($request->json()->all())
                    ->transformKeys(fn($key) => Str::snake($key))
                    ->toArray()
            );
        }
        return $next($request);
    }
}
