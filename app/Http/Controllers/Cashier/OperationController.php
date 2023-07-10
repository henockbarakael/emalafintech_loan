<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Cwallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OperationController extends Controller
{
    # Credit Cashier
    public function creditCashier($amount,$currency){

        $user_id = Auth::user()->id;
        $bwallet = Cwallet::select('amount')->where(['w_type'=>'credit','currency'=>$currency,'user_id'=>$user_id])->first();
        $current_balance = $bwallet->amount;
        $new_balance = $current_balance + $amount;
        $data = ['amount' => $new_balance];
        try {
            DB::beginTransaction();
            DB::table('cwallets')->where(['w_type'=>'credit','currency'=>$currency,'user_id'=>$user_id])->update($data);
            DB::commit();
            return response([
                'success' => true,
                'message' => 'Wallet credited successfuly!',
                'status' => 'Successful'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success' => false,
                'message' => $th->getMessage(),
                'status' => 'Failed'
            ]);
        }
    }

    # Debit Cashier
    public function debitCashierWallet($amount,$currency){
        $user_id = Auth::user()->id;
        $bwallet = Cwallet::select('amount')->where(['w_type'=>'debit','currency'=>$currency,'user_id'=>$user_id])->first();
        $current_balance = $bwallet->amount;

        if ($current_balance < $amount) {
            return response([
                'success' => false,
                'message' => 'Insufficient balance!',
                'code' => 300
            ]);
        }
        else {
            $new_balance = $current_balance - $amount;
            $data = ['amount' => $new_balance];
            try {
                DB::beginTransaction();
                DB::table('cwallets')->where(['w_type'=>'debit','currency'=>$currency,'user_id'=>$user_id])->update($data);
                DB::commit();
                return response([
                    'success' => true,
                    'message' => 'Wallet debited successfuly!',
                    'status' => 'Successful'
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response([
                    'success' => false,
                    'message' => $th->getMessage(),
                    'status' => 'Failed'
                ]);
            }
        }
    }

    # Make Deposit
    public function creditCustomer(Request $request){
        $request->validate([
            'amount'   => 'required|string|max:255',
            'currency'   => 'required|string|max:255',
            'acnumber'   => 'required|string|max:255',
        ]);
        $amount = $request->amount;
        $acnumber = $request->acnumber;
        $currency = $request->currency;

        $account = Account::select('balance')->where('acnumber',$acnumber)->first();
        $current_balance = $account->balance;
        $new_balance = $current_balance + $amount;
        $data = ['balance' => $new_balance];
        try {
            DB::beginTransaction();
            DB::table('accounts')->where('acnumber',$acnumber)->update($data);
            DB::commit();
            $this->creditCashier($amount,$currency);
            return response([
                'success' => true,
                'message' => 'Account credited successfuly!',
                'status' => 'Successful'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success' => false,
                'message' => $th->getMessage(),
                'status' => 'Failed'
            ]);
        }
    }

    # Make Withdrawal
    public function debitCustomer(Request $request){
        $request->validate([
            'amount'   => 'required|string|max:255',
            'currency'   => 'required|string|max:255',
            'acnumber'   => 'required|string|max:255',
        ]);
        $amount = $request->amount;
        $acnumber = $request->acnumber;
        $currency = $request->currency;

        $debit = $this->debitCashier($amount,$currency);

        if ($debit['code'] == 300) {
            return response([
                'success' => false,
                'message' => 'Votre solde caisse est insuffisante! Veuillez contacter le gérant.',
                'status' => 'Failed'
            ]);
        }
        else {
            if ($debit['success'] == true) {
                $account = Account::select('balance')->where('acnumber',$acnumber)->first();
                $current_balance = $account->balance;
                if ($current_balance < $amount) {
                    return response([
                        'success' => false,
                        'message' => 'Insufficient balance!',
                        'status' => 'Failed'
                    ]);
                }
                else {
                    $new_balance = $current_balance - $amount;
                    $data = ['balance' => $new_balance];
                    try {
                        DB::beginTransaction();
                        DB::table('accounts')->where('acnumber',$acnumber)->update($data);
                        DB::commit();
                        return response([
                            'success' => true,
                            'message' => 'Account credited successfuly!',
                            'status' => 'Successful'
                        ]);
                    } catch (\Throwable $th) {
                        DB::rollBack();
                        return response([
                            'success' => false,
                            'message' => $th->getMessage(),
                            'status' => 'Failed'
                        ]);
                    }
                }
            }
            else {
                return response([
                    'success' => false,
                    'message' => $debit['message'],
                    'status' => 'Failed'
                ]);
            }
        }
        
    }

    # Get Balance
    public function customerBalance($acnumber){
        $account = Account::select('balance')->where('acnumber',$acnumber)->first();
        $current_balance = $account->balance;
        return $current_balance;
    }
}
