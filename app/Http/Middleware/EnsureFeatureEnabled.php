<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\Feature;

class EnsureFeatureEnabled
{
    public function handle(Request $request, Closure $next, string $featureKey)
    {
        if (!Feature::enabled($featureKey)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This action is currently disabled.',
                ], 403);
            }
            return redirect()->back()->with('error', 'This action is currently disabled.');
        }
        return $next($request);
    }
}
