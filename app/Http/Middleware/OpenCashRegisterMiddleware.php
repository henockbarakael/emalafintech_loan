<?php

namespace App\Http\Middleware;

use App\Models\CashRegister;
use Closure;
use Illuminate\Http\Request;

class OpenCashRegisterMiddleware
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
            $cashRegister->balance = 0;
            $cashRegister->open();
        } elseif (!$cashRegister->is_open) {
            $cashRegister->open();
        }
        
        $openingBalance = $cashRegister->balance;
        
        $request->attributes->add(['cashRegister' => $cashRegister, 'openingBalance' => $openingBalance]);
        
        return $next($request);
    }
}
