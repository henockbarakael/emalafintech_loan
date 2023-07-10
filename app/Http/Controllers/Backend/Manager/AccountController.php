<?php

namespace App\Http\Controllers\Backend\Manager;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DateController;
use App\Http\Controllers\GenerateIdController;
use App\Models\Account;
use App\Models\Customer;
use App\Models\LoanPlan;
use App\Models\LoanType;
use App\Models\PretBancaire;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AccountController extends Controller
{
    public function branche_id()
    {
        $userInfo = UserInfo::where('user_id',Auth::user()->id)->first();
        $branche_id = $userInfo->branche_id;
        return $branche_id;
    }

    public function pret($id){

        $user_id =  Crypt::decrypt($id);

        $customer = Customer::join('users','customers.user_id','users.id')
        ->join('accounts','customers.id','accounts.customer_id')
        ->select('customers.*','accounts.balance_cdf','accounts.balance_usd','accounts.actype','accounts.acnumber','users.role_name','users.avatar')
        ->where('customers.user_id',$user_id)
        ->get();

        foreach ($customer as $key => $value) {
            $id_user = $value->user_id;
            $firstname = $value->firstname;
            $lastname = $value->lastname;
            $avatar = $value->avatar;
            $join_date = $value->created_at;
            $phone_number = $value->phone_number;
            $role_name = $value->role_name;
            $address = $value->address;
            $city = $value->city;

            if ($value->actype == "current") {
                $cnumber = $value->acnumber;
                $c_bcdf = $value->balance_cdf;
                $c_busd = $value->balance_usd;
            }
            if ($value->actype == "saving") {
                $snumber = $value->acnumber;
                $s_bcdf = $value->balance_cdf;
                $s_busd = $value->balance_usd;
            }
        }

        $transactions = Transaction::where(['transaction_from'=>$phone_number])->get();
        $plans = LoanPlan::first();
        $periodic_rate = $plans->rate;
        $types = LoanType::all();
        return view('backend.manager.operation.pret',compact('periodic_rate','transactions','plans','types','id_user','avatar','role_name','city','address','phone_number','join_date','lastname','firstname','c_bcdf','c_busd','s_bcdf','s_busd','cnumber','snumber'));
        
    }

    public function client($id){
        $user_id =  Crypt::decrypt($id);
        $customer = Customer::join('users','customers.user_id','users.id')
        ->join('accounts','customers.id','accounts.customer_id')
        ->select('customers.*','accounts.balance_cdf','accounts.balance_usd','accounts.actype','accounts.acnumber','users.role_name','users.avatar')
        ->where('customers.id',$user_id)
        ->get();

        foreach ($customer as $key => $value) {
            $id_user = $value->user_id;
            $firstname = $value->firstname;
            $lastname = $value->lastname;
            $avatar = $value->avatar;
            $join_date = $value->created_at;
            $phone_number = $value->phone_number;
            $role_name = $value->role_name;
            $address = $value->address;
            $city = $value->city;

            if ($value->actype == "current") {
                $cnumber = $value->acnumber;
                $c_bcdf = $value->balance_cdf;
                $c_busd = $value->balance_usd;
            }
            if ($value->actype == "saving") {
                $snumber = $value->acnumber;
                $s_bcdf = $value->balance_cdf;
                $s_busd = $value->balance_usd;
            }
        }
        $transactions = Transaction::where(['transaction_from'=>$phone_number])->get();
        return view('backend.manager.customer.account',compact('transactions','id_user','avatar','role_name','city','address','phone_number','join_date','lastname','firstname','c_bcdf','c_busd','s_bcdf','s_busd','cnumber','snumber'));

    }

    public function clientPhone($id){
        $phone_number =  Crypt::decrypt($id);
        $customer = Customer::join('users','customers.user_id','users.id')
        ->join('accounts','customers.id','accounts.customer_id')
        ->select('customers.*','accounts.balance_cdf','accounts.balance_usd','accounts.actype','accounts.acnumber','users.role_name','users.avatar')
        ->where('customers.phone_number',$phone_number)
        ->get();

        foreach ($customer as $key => $value) {
            $id_user = $value->user_id;
            $firstname = $value->firstname;
            $lastname = $value->lastname;
            $avatar = $value->avatar;
            $join_date = $value->created_at;
            $role_name = $value->role_name;
            $address = $value->address;
            $city = $value->city;

            if ($value->actype == "current") {
                $cnumber = $value->acnumber;
                $c_bcdf = $value->balance_cdf;
                $c_busd = $value->balance_usd;
            }
            if ($value->actype == "saving") {
                $snumber = $value->acnumber;
                $s_bcdf = $value->balance_cdf;
                $s_busd = $value->balance_usd;
            }
        }
        $transactions = Transaction::where(['transaction_from'=>$phone_number])->get();
        return view('backend.manager.customer.account',compact('transactions','id_user','avatar','role_name','city','address','phone_number','join_date','lastname','firstname','c_bcdf','c_busd','s_bcdf','s_busd','cnumber','snumber'));

    }

    public function client_depot($id){

        $user_id =  Crypt::decrypt($id);

        $customer = Customer::join('users','customers.user_id','users.id')
        ->join('accounts','customers.id','accounts.customer_id')
        ->select('customers.*','accounts.balance_cdf','accounts.balance_usd','accounts.actype','accounts.acnumber','users.role_name','users.avatar')
        ->where('customers.user_id',$user_id)
        ->get();

        foreach ($customer as $key => $value) {
            $id_user = $value->user_id;
            $firstname = $value->firstname;
            $lastname = $value->lastname;
            $avatar = $value->avatar;
            $join_date = $value->created_at;
            $phone_number = $value->phone_number;
            $role_name = $value->role_name;
            $address = $value->address;
            $city = $value->city;

            if ($value->actype == "current") {
                $cnumber = $value->acnumber;
                $c_bcdf = $value->balance_cdf;
                $c_busd = $value->balance_usd;
            }
            if ($value->actype == "saving") {
                $snumber = $value->acnumber;
                $s_bcdf = $value->balance_cdf;
                $s_busd = $value->balance_usd;
            }
        }

        $transactions = Transaction::where(['transaction_from'=>$phone_number])->get();
        return view('backend.manager.operation.depot',compact('transactions','id_user','avatar','role_name','city','address','phone_number','join_date','lastname','firstname','c_bcdf','c_busd','s_bcdf','s_busd','cnumber','snumber'));
        
    }

    public function client_depot_save(Request $request){

        $request->validate([
            'amount'   => 'required|string|max:255',
            'currency'   => 'required|string|max:255',
            'compte'   => 'required|string|max:255',
            'acnumber'   => 'required|string|max:255'
        ]);

        $customer_number = $request->receiver_phone;
        $acnumber = $request->acnumber;
        $fees = $request->fees;
        $amount = $request->amount;
        $currency = $request->currency;

        $date = new DateController;
        $today = $date->todayDate();

        $code = new GenerateIdController;
        $reference = $code->reference();

        DB::beginTransaction();

        $creditBranche =  new WalletController;
        

        if ($currency == "CDF") {
            $wallets = Account::select('balance_cdf')->where('acnumber',$acnumber)->first();
            $previous_balance = $wallets->balance_cdf;
            try {
                $save = DB::table('accounts')->where('acnumber',$acnumber)->update(['balance_cdf' => $amount + $previous_balance,'updated_at' => $today]);
                if ($save) {
                    
                    $wallets = Account::select('balance_cdf')->where('acnumber',$acnumber)->first();
                    $current_balance = $wallets->balance_cdf;
                    $creditBranche->creditWallet($amount,$currency);
                    DB::table('transactions')->insert(['user_id' => Auth::user()->id,'branche_id' => $this->branche_id(),'reference' => $reference,'currency' => $currency,'amount' => $amount,'previous_balance' => $previous_balance,'current_balance' => $current_balance,'fees' => $fees,'status' => 'Success','category' => 'depot','transaction_from' => $customer_number,'transaction_to' => $customer_number,'updated_at' => $today,'created_at' => $today]);
                    DB::commit();
                }
                
                Alert::success('Succès', 'Dépôt effectué avec succès !');
                return redirect()->route('manager.transaction.all');
            } catch (\Exception $e) {
                DB::rollback();
                Alert::error('Erreur', 'Une erreur est survenue lors du dépôt.');
                return redirect()->back();
            }
        }
        else {
            $wallets = Account::select('balance_usd')->where('acnumber',$acnumber)->first();
            $previous_balance = $wallets->balance_usd;
            try {
                $save = DB::table('accounts')->where('acnumber',$acnumber)->update(['balance_usd' => $amount + $previous_balance,'updated_at' => $today]);
                if ($save) {
                    $wallets = Account::select('balance_usd')->where('acnumber',$acnumber)->first();
                    $current_balance = $wallets->balance_usd;
                    $creditBranche->creditWallet($amount,$currency);
                    DB::table('transactions')->insert(['user_id' => Auth::user()->id,'branche_id' => $this->branche_id(),'reference' => $reference,'currency' => $currency,'amount' => $amount,'previous_balance' => $previous_balance,'current_balance' => $current_balance,'fees' => $fees,'status' => 'Success','category' => 'depot','transaction_from' => $customer_number,'transaction_to' => $customer_number,'updated_at' => $today,'created_at' => $today]);
                    DB::commit();
                }
                
                Alert::success('Succès', 'Dépôt effectué avec succès !');
                return redirect()->route('manager.transaction.all');
            } catch (\Exception $e) {
                DB::rollback();
                Alert::error('Erreur', 'Une erreur est survenue lors du dépôt');
                return redirect()->back();
            }
        }
    }


    public function client_retrait($id){
        $user_id =  Crypt::decrypt($id);

        $customer = Customer::join('users','customers.user_id','users.id')
        ->join('accounts','customers.id','accounts.customer_id')
        ->select('customers.*','accounts.balance_cdf','accounts.balance_usd','accounts.actype','accounts.acnumber','users.role_name','users.avatar')
        ->where('customers.user_id',$user_id)
        ->get();

        foreach ($customer as $key => $value) {
            $id_user = $value->user_id;
            $firstname = $value->firstname;
            $lastname = $value->lastname;
            $avatar = $value->avatar;
            $join_date = $value->created_at;
            $phone_number = $value->phone_number;
            $role_name = $value->role_name;
            $address = $value->address;
            $city = $value->city;

            if ($value->actype == "current") {
                $cnumber = $value->acnumber;
                $c_bcdf = $value->balance_cdf;
                $c_busd = $value->balance_usd;
            }
            if ($value->actype == "saving") {
                $snumber = $value->acnumber;
                $s_bcdf = $value->balance_cdf;
                $s_busd = $value->balance_usd;
            }
        }

        $transactions = Transaction::where(['transaction_from'=>$phone_number])->get();
        return view('backend.manager.operation.retrait',compact('transactions','id_user','avatar','role_name','city','address','phone_number','join_date','lastname','firstname','c_bcdf','c_busd','s_bcdf','s_busd','cnumber','snumber'));
        
    }

    public function client_retrait_save(Request $request){

        $request->validate([
            'amount'   => 'required|string|max:255',
            'currency'   => 'required|string|max:255',
            'compte'   => 'required|string|max:255',
            'acnumber'   => 'required|string|max:255'
        ]);

        $customer_number = $request->receiver_phone;
        $acnumber = $request->acnumber;
        $fees = $request->fees;
        $amount = $request->amount;
        $currency = $request->currency;

        $total = $amount + $fees;

        $response = $this->verifyUserBalance($total,$currency,$acnumber);

        if ($response['success'] == false) {
            Alert::error('Erreur', $response['message']);
            return redirect()->back();
        }
        else {
            $date = new DateController;
            $today = $date->todayDate();

            $code = new GenerateIdController;
            $reference = $code->reference();

            DB::beginTransaction();

            $debitBranche =  new WalletController;
            
            if ($currency == "CDF") {
                $wallets = Account::select('balance_cdf')->where('acnumber',$acnumber)->first();
                $previous_balance = $wallets->balance_cdf;
                try {
                    $save = DB::table('accounts')->where('acnumber',$acnumber)->update(['balance_cdf' => $previous_balance - $total,'updated_at' => $today]);
                    if ($save) {
                        
                        $wallets = Account::select('balance_cdf')->where('acnumber',$acnumber)->first();
                        $current_balance = $wallets->balance_cdf;
                        $debitBranche->debitWallet($amount,$currency);
                        DB::table('transactions')->insert(['user_id' => Auth::user()->id,'branche_id' => $this->branche_id(),'reference' => $reference,'currency' => $currency,'amount' => $amount,'previous_balance' => $previous_balance,'current_balance' => $current_balance,'fees' => $fees,'status' => 'Success','category' => 'retrait','transaction_from' => $customer_number,'transaction_to' => $customer_number,'updated_at' => $today,'created_at' => $today]);
                        DB::commit();
                    }
                    
                    Alert::success('Succès', 'Dépôt effectué avec succès !');
                    return redirect()->route('manager.transaction.all');
                } catch (\Exception $e) {
                    DB::rollback();
                    Alert::error('Erreur', 'Une erreur est survenue lors du dépôt.');
                    return redirect()->back();
                }
            }
            else {
                $wallets = Account::select('balance_usd')->where('acnumber',$acnumber)->first();
                $previous_balance = $wallets->balance_usd;
                try {
                    $save = DB::table('accounts')->where('acnumber',$acnumber)->update(['balance_usd' => $previous_balance - $total,'updated_at' => $today]);
                    if ($save) {
                        $wallets = Account::select('balance_usd')->where('acnumber',$acnumber)->first();
                        $current_balance = $wallets->balance_usd;
                        $debitBranche->debitWallet($amount,$currency);
                        DB::table('transactions')->insert(['user_id' => Auth::user()->id,'branche_id' => $this->branche_id(),'reference' => $reference,'currency' => $currency,'amount' => $amount,'previous_balance' => $previous_balance,'current_balance' => $current_balance,'fees' => $fees,'status' => 'Success','category' => 'retrait','transaction_from' => $customer_number,'transaction_to' => $customer_number,'updated_at' => $today,'created_at' => $today]);
                        DB::commit();
                    }
                    
                    Alert::success('Succès', 'Dépôt effectué avec succès !');
                    return redirect()->route('manager.transaction.all');
                } catch (\Exception $e) {
                    DB::rollback();
                    Alert::error('Erreur', 'Une erreur est survenue lors du dépôt');
                    return redirect()->back();
                }
            }
        }

        
    }

    public function client_transfert($id){
        $user_id =  Crypt::decrypt($id);

        $customer = Customer::join('users','customers.user_id','users.id')
        ->join('accounts','customers.id','accounts.customer_id')
        ->select('customers.*','accounts.balance_cdf','accounts.balance_usd','accounts.actype','accounts.acnumber','users.role_name','users.avatar')
        ->where('customers.user_id',$user_id)
        ->get();

        $receiver = DB::table('customers')->distinct('customers.phone_number')
        ->select('customers.phone_number','customers.lastname','customers.firstname')
        ->get();

        foreach ($customer as $key => $value) {
            $id_user = $value->user_id;
            $firstname = $value->firstname;
            $lastname = $value->lastname;
            $avatar = $value->avatar;
            $join_date = $value->created_at;
            $phone_number = $value->phone_number;
            $role_name = $value->role_name;
            $address = $value->address;
            $city = $value->city;

            if ($value->actype == "current") {
                $cnumber = $value->acnumber;
                $c_bcdf = $value->balance_cdf;
                $c_busd = $value->balance_usd;
            }
            if ($value->actype == "saving") {
                $snumber = $value->acnumber;
                $s_bcdf = $value->balance_cdf;
                $s_busd = $value->balance_usd;
            }
        }

        $transactions = Transaction::where(['transaction_from'=>$phone_number])->get();
        return view('backend.manager.operation.transfert',compact('receiver','transactions','id_user','avatar','role_name','city','address','phone_number','join_date','lastname','firstname','c_bcdf','c_busd','s_bcdf','s_busd','cnumber','snumber'));
        
    }

    public function creditReceiver($amount,$currency,$acnumber,$sender_number,$receiver_number,$fees){

        $date = new DateController;
        $today = $date->todayDate();

        $code = new GenerateIdController;
        $reference = $code->reference();

        DB::beginTransaction();

        

        if ($currency == "CDF") {
            $wallets = Account::select('balance_cdf')->where('acnumber',$acnumber)->first();
            $previous_balance = $wallets->balance_cdf;
            try {
                DB::table('accounts')->where('acnumber',$acnumber)->update(['balance_cdf' => $amount + $previous_balance,'updated_at' => $today]);
                DB::commit();
                return ["success"=>true];

            } catch (\Exception $e) {
                DB::rollback();
                return ["success"=>false,"message"=>"Une erreur est survenue lors du transfert"];
            }
        }
        else {
            $wallets = Account::select('balance_usd')->where('acnumber',$acnumber)->first();
            $previous_balance = $wallets->balance_usd;
            try {
                DB::table('accounts')->where('acnumber',$acnumber)->update(['balance_usd' => $amount + $previous_balance,'updated_at' => $today]);
                DB::commit();
                return ["success"=>true];

            } catch (\Exception $e) {
                DB::rollback();
                return ["success"=>false,"message"=>"Une erreur est survenue lors du transfert"];
            }
        }
    }

    public function client_transfert_save(Request $request){

        $request->validate([
            'amount'   => 'required|string|max:255',
            'currency'   => 'required|string|max:255',
            'compte'   => 'required|string|max:255',
            'compte_receiver'   => 'required|string|max:255',
            'acnumber'   => 'required|string|max:255'
        ]);

        $sender_number = $request->customer_number;
        $receiver_number = $request->receiver_number;
        $acnumber = $request->acnumber;
        $fees = $request->fees;
        $amount = $request->amount;
        $currency = $request->currency;

        $user = User::where('phone_number',$receiver_number)->first();
        $customer = Customer::where('user_id',$user->id)->first();
        $receiverId = $customer->id;

        $r_account = Account::where(['customer_id'=>$receiverId,'actype'=>$request->compte_receiver])->first();
        $racnumber = $r_account->acnumber;
        
        $total = $amount + $fees;

        $response = $this->verifyUserBalance($total,$currency,$acnumber);

        

        if ($response['success'] == false) {
            Alert::error('Erreur', $response['message']);
            return redirect()->back();
        }
        else {
            $date = new DateController;
            $today = $date->todayDate();

            $code = new GenerateIdController;
            $reference = $code->reference();

            DB::beginTransaction();

         
            
            if ($currency == "CDF") {
                $wallets = Account::select('balance_cdf')->where('acnumber',$acnumber)->first();
                $previous_balance = $wallets->balance_cdf;
                try {
                    $save = DB::table('accounts')->where('acnumber',$acnumber)->update(['balance_cdf' => $previous_balance - $total,'updated_at' => $today]);
                    if ($save) {
                        
                        $wallets = Account::select('balance_cdf')->where('acnumber',$acnumber)->first();
                        $current_balance = $wallets->balance_cdf;
                        $this->creditReceiver($amount,$currency,$racnumber,$sender_number,$receiver_number,$fees);
                        DB::table('transactions')->insert(['user_id' => Auth::user()->id,'branche_id' => $this->branche_id(),'reference' => $reference,'currency' => $currency,'amount' => $amount,'previous_balance' => $previous_balance,'current_balance' => $current_balance,'fees' => $fees,'status' => 'Success','category' => 'transfert','transaction_from' => $sender_number,'transaction_to' => $receiver_number,'updated_at' => $today,'created_at' => $today]);
                        DB::commit();
                    }
                    
                    Alert::success('Succès', 'Transfert effectué avec succès !');
                    return redirect()->route('manager.transaction.all');
                } catch (\Exception $e) {
                    DB::rollback();
                    Alert::error('Erreur', 'Une erreur est survenue lors du transfert.');
                    return redirect()->back();
                }
            }
            else {
                $wallets = Account::select('balance_usd')->where('acnumber',$acnumber)->first();
                $previous_balance = $wallets->balance_usd;
                // dd($acnumber);
                try {
                    $save = DB::table('accounts')->where('acnumber',$acnumber)->update(['balance_usd' => $previous_balance - $total,'updated_at' => $today]);
                    if ($save) {
                        $wallets = Account::select('balance_usd')->where('acnumber',$acnumber)->first();
                        $current_balance = $wallets->balance_usd;
                        $this->creditReceiver($amount,$currency,$racnumber,$sender_number,$receiver_number,$fees);
                        DB::table('transactions')->insert(['user_id' => Auth::user()->id,'branche_id' => $this->branche_id(),'reference' => $reference,'currency' => $currency,'amount' => $amount,'previous_balance' => $previous_balance,'current_balance' => $current_balance,'fees' => $fees,'status' => 'Success','category' => 'transfert','transaction_from' => $sender_number,'transaction_to' => $receiver_number,'updated_at' => $today,'created_at' => $today]);
                        DB::commit();
                    }
                    
                    Alert::success('Succès', 'Transfert effectué avec succès !');
                    return redirect()->route('manager.transaction.all');
                } catch (\Exception $e) {
                    DB::rollback();
                    Alert::error('Erreur', 'Une erreur est survenue lors du transfert');
                    return redirect()->back();
                }
            }
        }

        
    }

    public function verifyUserBalance($amount,$currency,$acnumber){
      
        if ($currency == "CDF") {
            $wallets = Account::select('balance_cdf')->where('acnumber',$acnumber)->first();
            $current_balance = $wallets->balance_cdf;
            if ($amount > $current_balance) {
                return ["success"=>false,"message"=>"Le solde de ce compte est insuffisant pour effectuer cette opération."];
            }
            else {
                return ["success"=>true];
            }

        }
        else {
            $wallets = Account::select('balance_usd')->where('acnumber',$acnumber)->first();;
            $current_balance = $wallets->balance_usd;
            if ($amount > $current_balance) {
                return ["success"=>false,"message"=>"Le solde de ce compte est insuffisant pour effectuer cette opération."];
            }
            else {
                return ["success"=>true];
            }
        }
    }

    public function remboursement($id){

        $user_id =  Crypt::decrypt($id);

        $customer = Customer::join('users','customers.user_id','users.id')
        ->join('accounts','customers.id','accounts.customer_id')
        ->select('customers.*','accounts.balance_cdf','accounts.balance_usd','accounts.actype','accounts.acnumber','users.role_name','users.avatar')
        ->where('customers.user_id',$user_id)
        ->get();

        $test = Customer::select('id')->where('user_id',$user_id)->first();
        $pret = PretBancaire::where('customer_id',$test->id)->first();

        foreach ($customer as $key => $value) {
            $id_user = $value->user_id;
            $firstname = $value->firstname;
            $lastname = $value->lastname;
            $avatar = $value->avatar;
            $join_date = $value->created_at;
            $phone_number = $value->phone_number;
            $role_name = $value->role_name;
            $address = $value->address;
            $city = $value->city;

            if ($value->actype == "current") {
                $cnumber = $value->acnumber;
                $c_bcdf = $value->balance_cdf;
                $c_busd = $value->balance_usd;
            }
            if ($value->actype == "saving") {
                $snumber = $value->acnumber;
                $s_bcdf = $value->balance_cdf;
                $s_busd = $value->balance_usd;
            }
        }

        $transactions = Transaction::where(['transaction_from'=>$phone_number])->get();
        return view('backend.manager.operation.remboursement',compact('pret','transactions','id_user','avatar','role_name','city','address','phone_number','join_date','lastname','firstname','c_bcdf','c_busd','s_bcdf','s_busd','cnumber','snumber'));
        
    }

}
