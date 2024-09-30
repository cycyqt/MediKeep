<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log user activity
        $this->logUserActivity($request, $response);

        return $response;
    }

    protected function logUserActivity(Request $request, Response $response)
    {
        $user = Auth::user();
        $timestamp = now()->format('Y-m-d H:i:s');
        $action = $this->getAction($request);
        $details = $this->getDetails($request, $response);
        Log::info("User {$user->id} ({$user->name}) performed action '{$action}' at {$timestamp} with details: {$details}");
    }

    protected function getAction(Request $request)
    {
        return $request->route()->getName() . ' (' . $request->method() . ')';
    }

    protected function getDetails(Request $request, Response $response)
    {
        $details = [
            'Request Headers' => $request->headers->all(),
            'Request Body' => $request->all(),
            'Response Status Code' => $response->getStatusCode(),
        ];

        return json_encode($details, JSON_PRETTY_PRINT);
    }
}