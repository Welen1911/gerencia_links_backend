<?php

namespace App\Http\Middleware;

use App\Models\Domain;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DomainApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->bearerToken();

        if (! $apiKey) {
            return response()->json(['message' => 'API key missing'], 401);
        }

        $domain = Domain::where('api_key', $apiKey)
            ->where('is_active', true)
            ->first();
        
        if (! $domain) {
            return response()->json(['message' => 'Invalid API key'], 403);
        }

        // disponibiliza o domínio na request
        $request->attributes->set('domain', $domain);

        return $next($request);
    }
}
