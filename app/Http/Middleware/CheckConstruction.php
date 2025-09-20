<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Config;

class CheckConstruction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $config = Config::first();
        
        // If construction mode is enabled and user is not accessing admin routes or construction page
        if ($config && $config->is_construction == 1) {
            // Allow access to admin routes and construction page
            if (!$request->is('admin/*') && !$request->is('construction') && !$request->is('login')) {
                return response()->view('construction', compact('config'));
            }
        }
        
        return $next($request);
    }
}