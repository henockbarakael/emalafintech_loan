<?php

namespace App\Http\Controllers;

use App\Models\Bwallet;
use App\Models\Cwallet;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function mainWallet(){
        return view('wallet.main.index');
    }

    public function creditMainWallet(Request $request){
        $request->validate([
            'amount'   => 'required|string|max:255',
            'w_code'   => 'required|string|max:255',
        ]);

        $amount = $request->amount;
        $w_code = $request->w_code;

        $wallet = Wallet::select('amount')->where('w_code',$w_code)->first();
        $current_balance = $wallet->amount;
        $new_balance = $current_balance + $amount;
        $data = ['amount' => $new_balance];
        try {
            DB::beginTransaction();
            DB::table('wallets')->where('w_code',$w_code)->update($data);
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

    public function debitMainWallet(Request $request){
        $request->validate([
            'amount'   => 'required|string|max:255',
            'w_code'   => 'required|string|max:255',
        ]);

        $amount = $request->amount;
        $w_code = $request->w_code;

        $wallet = Wallet::select('amount')->where('w_code',$w_code)->first();
        $current_balance = $wallet->amount;

        if ($current_balance < $amount) {
            return response([
                'success' => false,
                'message' => 'Insufficient balance!',
                'status' => 'Failed'
            ]);
        }
        else {
            $new_balance = $current_balance - $amount;
            $data = ['amount' => $new_balance];
            try {
                DB::beginTransaction();
                DB::table('wallets')->where('w_code',$w_code)->update($data);
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

    public function debit_wallet_credit($amount,$currency){
        $wallet = Wallet::select('amount')->where(['w_type'=>'credit','currency'=>$currency])->first();
        $current_balance = $wallet->amount;
        if ($current_balance < $amount) {
            return response([
                'success' => false,
                'message' => 'Insufficient balance!',
                'status' => 'Failed'
            ]);
        }
        else {
            $new_balance = $current_balance - $amount;
            $data = ['amount' => $new_balance];
            try {
                DB::beginTransaction();
                DB::table('wallets')->where(['w_type'=>'credit','currency'=>$currency])->update($data);
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

    public function brancheWallet(){
        return view('wallet.branche.index');
    }

    public function creditBrancheWallet(Request $request){
        $request->validate([
            'amount'   => 'required|string|max:255',
            'currency'   => 'required|string|max:255',
            'w_code'   => 'required|string|max:255',
        ]);

        $amount = $request->amount;
        $currency = $request->currency;
        $w_code = $request->w_code;

        $debit = $this->debit_wallet_credit($amount,$currency);

        if ($debit['success'] == true) {
            $bwallet = Bwallet::select('amount')->where(['w_type'=>'credit','currency'=>$currency])->first();
            $current_balance = $bwallet->amount;
            $new_balance = $current_balance + $amount;
            $data = ['amount' => $new_balance];
            try {
                DB::beginTransaction();
                DB::table('bwallets')->where('w_code',$w_code)->update($data);
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
        else {
            return response([
                'success' => false,
                'message' => $debit['message'],
                'status' => 'Failed'
            ]);
        }
        
    }

    public function debitBrancheWallet(Request $request){
        $request->validate([
            'amount'   => 'required|string|max:255',
            'w_code'   => 'required|string|max:255',
        ]);

        $amount = $request->amount;
        $w_code = $request->w_code;

        $wallet = Bwallet::select('amount')->where('w_code',$w_code)->first();
        $current_balance = $wallet->amount;

        if ($current_balance < $amount) {
            return response([
                'success' => false,
                'message' => 'Insufficient balance!',
                'status' => 'Failed'
            ]);
        }
        else {
            $new_balance = $current_balance - $amount;
            $data = ['amount' => $new_balance];
            try {
                DB::beginTransaction();
                DB::table('bwallets')->where('w_code',$w_code)->update($data);
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

    public function cashierWallet(){
        return view('wallet.cashier.index');
    }

    public function debit_bwallet_credit($amount,$currency,$brancheID){
        $wallet = Bwallet::select('amount')->where(['w_type'=>'credit','currency'=>$currency,'branche_id'=>$brancheID])->first();
        $current_balance = $wallet->amount;
        if ($current_balance < $amount) {
            return response([
                'success' => false,
                'message' => 'Insufficient balance!',
                'status' => 'Failed'
            ]);
        }
        else {
            $new_balance = $current_balance - $amount;
            $data = ['amount' => $new_balance];
            try {
                DB::beginTransaction();
                DB::table('bwallets')->where(['w_type'=>'credit','currency'=>$currency,'branche_id'=>$brancheID])->update($data);
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

    public function creditCashierWallet(Request $request){
        $request->validate([
            'amount'   => 'required|string|max:255',
            'currency'   => 'required|string|max:255',
            'w_code'   => 'required|string|max:255',
            'branche_id'   => 'required|string|max:255',
        ]);

        $amount = $request->amount;
        $currency = $request->currency;
        $w_code = $request->w_code;
        $brancheID = $request->branche_id;

        $debit = $this->debit_bwallet_credit($amount,$currency,$brancheID);

        if ($debit['success'] == true) {
            $bwallet = Cwallet::select('amount')->where(['w_type'=>'credit','currency'=>$currency])->first();
            $current_balance = $bwallet->amount;
            $new_balance = $current_balance + $amount;
            $data = ['amount' => $new_balance];
            try {
                DB::beginTransaction();
                DB::table('cwallets')->where('w_code',$w_code)->update($data);
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
        else {
            return response([
                'success' => false,
                'message' => $debit['message'],
                'status' => 'Failed'
            ]);
        }
    }

    public function debitCashierWallet(Request $request){
        $request->validate([
            'amount'   => 'required|string|max:255',
            'w_code'   => 'required|string|max:255',
        ]);

        $amount = $request->amount;
        $w_code = $request->w_code;

        $wallet = Cwallet::select('amount')->where('w_code',$w_code)->first();
        $current_balance = $wallet->amount;

        if ($current_balance < $amount) {
            return response([
                'success' => false,
                'message' => 'Insufficient balance!',
                'status' => 'Failed'
            ]);
        }
        else {
            $new_balance = $current_balance - $amount;
            $data = ['amount' => $new_balance];
            try {
                DB::beginTransaction();
                DB::table('cwallets')->where('w_code',$w_code)->update($data);
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
}
