<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use Illuminate\Http\Request;
use App\Http\Middleware\OpenCashRegisterMiddleware;
use App\Http\Middleware\CloseCashRegisterMiddleware;
use App\Models\Checkout;

class CashRegisterController extends Controller
{
    // public function open(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $openingBalance = $request->input('opening_balance');

    //         $cashRegister = new CashRegister;
    //         $cashRegister->balance = $openingBalance;
    //         $cashRegister->open();
    //         $cashRegister->save();

    //         return redirect()->route('home');
    //     }
    //     return view('cash-register-open');
    // }
    // public function close(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $closingBalance = $request->input('closing_balance');

    //         $cashRegister = CashRegister::firstOrFail();
    //         $cashRegister->balance = $closingBalance;
    //         $cashRegister->close();
    //         $cashRegister->save();

    //         return redirect()->route('home');
    //     }
    //     return view('cash-register-close');
    // }
    public function showOpeningBalanceForm()
    {
        return view('opening_balance_form');
    }

    public function setOpeningBalance(Request $request)
    {
        $cashRegister = $request->attributes->get('cashRegister');
        $openingBalance = $request->attributes->get('openingBalance');
        $openingBalance = $request->input('opening_balance');

        $cashRegister->balance = $openingBalance;
        $cashRegister->save();

        return redirect()->route('home');
    }

    public function showCloseCashRegisterForm()
    {
        return view('close_cash_register_form');
    }

    public function closeCashRegister(Request $request)
    {
        $cashRegister = $request->attributes->get('cashRegister');
        $closingBalance = $request->input('closing_balance');

        $cashRegister->balance = $closingBalance;
        $cashRegister->close();
        $cashRegister->save();

        $checkout = new Checkout();
        $checkout->user_id = auth()->id();
        $checkout->cash_register_id = $cashRegister->id;
        $checkout->opening_balance = $request->input('opening_balance');
        $checkout->closing_balance = $closingBalance;
        $checkout->opened_at = $request->attributes->get('checkoutOpenedAt');
        $checkout->closed_at = now();
        $checkout->save();

        return redirect()->route('home');
    }
}
