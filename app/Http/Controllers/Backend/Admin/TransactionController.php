<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function all(){
        $transactions = Transaction::all();
        return view('backend.transaction.admin.all',compact('transactions'));
    }

    public function deposit(){
        $transactions = Transaction::where('category','depot')->get();
        return view('backend.transaction.admin.deposit',compact('transactions'));
    }

    public function transfer(){
        $transactions = Transaction::where('category','transfert')->get();
        return view('backend.transaction.admin.transfer',compact('transactions'));
    }

    public function withdrawal(){
        $transactions = Transaction::where('category','retrait')->get();
        return view('backend.transaction.admin.withdrawal',compact('transactions'));
    }

    public function search(Request $request){
        $transactions = Transaction::all();
        $transaction_from = $request->transaction_from;
        $transaction_to = $request->transaction_to;
        $date = Carbon::parse($request->transaction_dat);
       
        if($request->transaction_from){
            $transactions = Transaction::where('transaction_from','LIKE','%'.$transaction_from.'%')->get();
        }

        if($request->transaction_to){
            $transactions = Transaction::where('transaction_to','LIKE','%'.$transaction_to.'%')->get();
        }

        if($request->date){
            $transactions = Transaction::where('transaction_to','LIKE','%'.$date.'%')->get();
        }
        return view('backend.transaction.admin.all',compact('transactions'));
    }
}
