<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DateController;
use App\Http\Controllers\GenerateIdController;
use App\Models\Branch;
use App\Models\BrancheWalleht;
use App\Models\BrancheWallet;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class WalletController extends Controller
{
    public function emala(){
        $wallets = Wallet::all();
        return view('backend.wallet.emala',compact('wallets'));
    }

    public function agence(){
        $wallets = BrancheWallet::join('branches','branche_wallets.branche_id','branches.id')
        ->select('branches.bname','branche_wallets.*')
        ->get();
        $branches = Branch::all();
        return view('backend.wallet.agence',compact('wallets','branches'));
    }

    public function walletAgenceAdd(Request $request){
        $request->validate([
            'branche_id'   => 'required|string|max:255'
        ]);

        $date = new DateController;
        $today = $date->todayDate();
        $acnumber = new GenerateIdController;
        $walletDebit = $acnumber->walletdebit();
        $walletCredit = $acnumber->walletcredit();
        $data = [
            [
                'w_code' => $walletCredit,
                'w_cdf' => 0,
                'w_usd' => 0,
                'w_type' => "credit",
                'branche_id' => $request->branche_id,
                'created_at' => $today,
                'updated_at' => $today
            ],

            [
                'w_code' => $walletDebit,
                'w_cdf' => 0,
                'w_usd' => 0,
                'branche_id' => $request->branche_id,
                'w_type' => "debit",
                'created_at' => $today,
                'updated_at' => $today
            ]
        ];
        BrancheWallet::insert($data);
        Alert::success('Succès', 'Wallet créer avec succès !');
        return redirect()->route('admin.wallet.agence');
    }

    public function walletEmalaTopup(Request $request){
        $request->validate([
            'amount'   => 'required|string|max:255',
            'currency'   => 'required|string|max:255'
        ]);

        $date = new DateController;
        $today = $date->todayDate();

        DB::beginTransaction();

        if ($request->currency == "CDF") {
            $wallets = Wallet::select('w_cdf')->where('w_type',$request->w_type)->first();
            $current_balance = $wallets->w_cdf;
            try {
                DB::table('wallets')->where('w_type',$request->w_type)->update(['w_cdf' => $request->amount + $current_balance,'updated_at' => $today]);
                DB::commit();
                Alert::success('Succès', 'Wallet rechargé avec succès !');
                return redirect()->route('admin.wallet.emala');
            } catch (\Exception $e) {
                DB::rollback();
                Alert::error('Erreur', 'Une erreur est survenue lors de la recharge du wallet');
                return redirect()->route('admin.wallet.emala');
            }
        }
        else {
            $wallets = Wallet::select('w_usd')->where('w_type',$request->w_type)->first();
            $current_balance = $wallets->w_usd;
            try {
                DB::table('wallets')->where('w_type',$request->w_type)->update(['w_usd' => $request->amount + $current_balance,'updated_at' => $today]);
                DB::commit();
                Alert::success('Succès', 'Wallet rechargé avec succès !');
                return redirect()->route('admin.wallet.emala');
            } catch (\Exception $e) {
                DB::rollback();
                Alert::error('Erreur', 'Une erreur est survenue lors de la recharge du wallet');
                return redirect()->route('admin.wallet.emala');
            }
        }

        
        
    }

    public function walletAgenceTopup(Request $request){
        $request->validate([
            'amount'   => 'required|string|max:255',
            'currency'   => 'required|string|max:255'
        ]);

        $date = new DateController;
        $today = $date->todayDate();

        $amount = $request->amount;
        $currency = $request->currency;
        $w_type = $request->w_type;

        $response = $this->debitWalletEmala($amount,$currency,$w_type);

        if ($response["success"]==true) {
            DB::beginTransaction();

            if ($request->currency == "CDF") {
                $wallets = BrancheWallet::select('w_cdf')->where('w_type',$request->w_type)->first();
                $current_balance = $wallets->w_cdf;
                try {
                    DB::table('branche_wallets')->where('w_type',$request->w_type)->update(['w_cdf' => $request->amount + $current_balance,'updated_at' => $today]);
                    DB::commit();
                    Alert::success('Succès', 'Wallet rechargé avec succès !');
                    return redirect()->route('admin.wallet.agence');
                } catch (\Exception $e) {
                    DB::rollback();
                    Alert::error('Erreur', 'Une erreur est survenue lors de la recharge du wallet');
                    return redirect()->route('admin.wallet.agence');
                }
            }
            else {
                $wallets = BrancheWallet::select('w_usd')->where('w_type',$request->w_type)->first();
                $current_balance = $wallets->w_usd;
                try {
                    DB::table('branche_wallets')->where('w_type',$request->w_type)->update(['w_usd' => $request->amount + $current_balance,'updated_at' => $today]);
                    DB::commit();
                    Alert::success('Succès', 'Wallet rechargé avec succès !');
                    return redirect()->route('admin.wallet.agence');
                } catch (\Exception $e) {
                    DB::rollback();
                    Alert::error('Erreur', 'Une erreur est survenue lors de la recharge du wallet');
                    return redirect()->route('admin.wallet.agence');
                }
            }
        }
        else {
            Alert::error('Erreur', $response["message"]);
            return redirect()->route('admin.wallet.agence');
        }

        

        
        
    }
    public function debitWalletEmala($amount,$currency,$w_type){
        $date = new DateController;
        $today = $date->todayDate();
        if ($currency == "CDF") {
            $wallets = Wallet::select('w_cdf')->where('w_type',$w_type)->first();
            $current_balance = $wallets->w_cdf;
            if ($amount > $current_balance) {
                return ["success"=>false,"message"=>"Le solde de ce compte est insuffisant pour effectuer cette opération."];
            }
            else {
                DB::beginTransaction();
                try {
                    DB::table('wallets')->where('w_type',$w_type)->update(['w_cdf' => $current_balance - $amount,'updated_at' => $today]);
                    DB::commit();
                    return ["success"=>true,"message"=>"Excellent"];
                } catch (\Exception $e) {
                    DB::rollback();
                    return ["success"=>false,"message"=>"Erreur lors du debit du wallet principal."];
                }
            }
        }
        else {
            $wallets = Wallet::select('w_usd')->where('w_type',$w_type)->first();
            $current_balance = $wallets->w_usd;
            if ($amount > $current_balance) {
                return ["success"=>false,"message"=>"Le solde de ce compte est insuffisant pour effectuer cette opération."];
            }
            else {
                DB::beginTransaction();
                try {
                    DB::table('wallets')->where('w_type',$w_type)->update(['w_usd' => $current_balance - $amount,'updated_at' => $today]);
                    DB::commit();
                    return ["success"=>true,"message"=>"Excellent"];
                } catch (\Exception $e) {
                    DB::rollback();
                    return ["success"=>false,"message"=>"Erreur lors du debit du wallet principal."];
                }
            }
        }
    }


    public function creditWallet($amount,$currency){

        $date = new DateController;
        $today = $date->todayDate();

        DB::beginTransaction();

        if ($currency == "CDF") {
            $wallets = Wallet::select('w_cdf')->where('w_type','credit')->first();
            $current_balance = $wallets->w_cdf;
            try {
                DB::table('wallets')->where('w_type','credit')->update(['w_cdf' => $amount + $current_balance,'updated_at' => $today]);
                DB::commit();
                return ["success"=>true,"message"=>"Excellent"];
            } catch (\Exception $e) {
                DB::rollback();
                return ["success"=>false,"message"=>"Erreur lors du debit du wallet principal."];
            }
        }
        else {
            $wallets = Wallet::select('w_usd')->where('w_type','credit')->first();
            $current_balance = $wallets->w_usd;
            try {
                DB::table('wallets')->where('w_type','credit')->update(['w_usd' => $amount + $current_balance,'updated_at' => $today]);
                DB::commit();
                return ["success"=>true,"message"=>"Excellent"];
            } catch (\Exception $e) {
                DB::rollback();
                return ["success"=>false,"message"=>"Erreur lors du debit du wallet principal."];
            }
        }

        
        
    }


    public function debitWallet($amount,$currency){
        $date = new DateController;
        $today = $date->todayDate();
        if ($currency == "CDF") {
            $wallets = Wallet::select('w_cdf')->where('w_type','debit')->first();
            $current_balance = $wallets->w_cdf;
            if ($amount > $current_balance) {
                return ["success"=>false,"message"=>"Le solde de ce compte est insuffisant pour effectuer cette opération."];
            }
            else {
                DB::beginTransaction();
                try {
                    DB::table('wallets')->where('w_type','debit')->update(['w_cdf' => $current_balance - $amount,'updated_at' => $today]);
                    DB::commit();
                    return ["success"=>true,"message"=>"Excellent"];
                } catch (\Exception $e) {
                    DB::rollback();
                    return ["success"=>false,"message"=>"Erreur lors du debit du wallet principal."];
                }
            }
        }
        else {
            $wallets = Wallet::select('w_usd')->where('w_type','debit')->first();
            $current_balance = $wallets->w_usd;
            if ($amount > $current_balance) {
                return ["success"=>false,"message"=>"Le solde de ce compte est insuffisant pour effectuer cette opération."];
            }
            else {
                DB::beginTransaction();
                try {
                    DB::table('wallets')->where('w_type','debit')->update(['w_usd' => $current_balance - $amount,'updated_at' => $today]);
                    DB::commit();
                    return ["success"=>true,"message"=>"Excellent"];
                } catch (\Exception $e) {
                    DB::rollback();
                    return ["success"=>false,"message"=>"Erreur lors du debit du wallet principal."];
                }
            }
        }
    }
}
