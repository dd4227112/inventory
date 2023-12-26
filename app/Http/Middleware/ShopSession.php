<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class ShopSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( strtolower(Auth::user()->role->name) =='admin' || strtolower(Auth::user()->role->name) =='auditor') {
            // Check if the shop_id session is not set
            if (!session()->has('shop_id')) {
                return redirect('/admin');
            }
        }
        return $next($request);
    }
}
