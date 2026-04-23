<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogApiRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        $response = $next($request);

        $duration = (int) ((microtime(true) - $startTime) * 1000);

        try {
            \App\Models\ApiLog::create([
                'user_id' => $request->user()?->id,
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'payload' => $request->all(),
                'response' => $this->getResponseData($response),
                'status_code' => $response->getStatusCode(),
                'duration_ms' => $duration,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log API request: ' . $e->getMessage());
        }

        return $response;
    }

    protected function getResponseData($response)
    {
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response->getData(true);
        }

        return null;
    }
}
