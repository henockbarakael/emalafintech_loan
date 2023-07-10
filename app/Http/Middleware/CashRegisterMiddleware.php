<?php

namespace App\Http\Middleware;

use App\Models\CashRegister;
use App\Models\Checkout;
use Closure;
use Illuminate\Http\Request;

class CashRegisterMiddleware
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
        $cashRegister = CashRegister::first();
        
        if (!$cashRegister) {
            $cashRegister = new CashRegister;
            $cashRegister->open();
        } elseif (!$cashRegister->is_open) {
            return redirect()->route('cash-register.closed');
        }
        
        $response = $next($request);
        
        if ($this->isLastCheckoutSessionOpen()) {
            // Do something here to continue the session
        } else {
            $cashRegister->close();
        }
        
        return $response;
    }

    private function isLastCheckoutSessionOpen()
    {
        // Add logic here to check if the last checkout session was open
        // Return true or false
        $lastCheckout = Checkout::latest()->first();
        if (!$lastCheckout||is_null($lastCheckout->closed_at)) {
            // Last checkout session is still open
            return true;
        }else {
            // Last checkout session is closed
            return false;
        }
    }
}
