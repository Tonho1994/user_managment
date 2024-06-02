<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? $this->failedAuthentication() : route('login');
    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function failedAuthentication()
    {
    throw new HttpResponseException(response()->json([
        'success'   => false,
        'message'   => 'Authentication error',
        'data' => [
            'error' => 'Must login first',
        ]
    ]));
    }
}
