<?php

namespace App\Http\Middleware;

use App\Models\Checkout;
use Closure;
use Illuminate\Http\Request;

class CloseCashRegisterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $lastCheckout = Checkout::latest()->first();

        if (!$lastCheckout || !is_null($lastCheckout->closed_at)) {
            return $next($request);
        } else {
            return redirect()->route('home')->with('error', 'Please close the last checkout session before closing the cash register.');
        }
    }
}
