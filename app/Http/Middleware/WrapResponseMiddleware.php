<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WrapResponseMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $content = json_decode($response->getContent(), true);

            $wrappedContent = [
                'success' => true,
                'data' => $content,
                'meta' => [
                    'end_time' => Carbon::now()
                ],
            ];

            return response()->json($wrappedContent);
        }

        return $response;
    }
}
