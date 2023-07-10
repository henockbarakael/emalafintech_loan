<?php

namespace App\Http\Controllers;

use App\Models\BrancheWallet;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin()
    {
        $transactions = Transaction::count();
        $customers = Customer::count();
        return view('backend.dashboard.admin',compact('transactions','customers'));
    }

    public function manager()
    {
        $userInfo = UserInfo::where('user_id',Auth::user()->id)->first();
        $agence = BrancheWallet::where('branche_id',$userInfo->branche_id)->first();
        $solde_cdf = $agence->w_cdf;
        $solde_usd = $agence->w_usd;
        $transactions = DB::table('transactions')
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when category = 'retrait' then 1 end) as retrait")
            ->selectRaw("count(case when category = 'depot' then 1 end) as depot")
            ->selectRaw("count(case when category = 'transfert' then 1 end) as transfert")
            ->where('branche_id',$userInfo->branche_id)->first();
        $retrait_cdf= DB::table("transactions")->where(['branche_id'=>$userInfo->branche_id,'currency'=>'CDF','category'=>'retrait'])->sum('amount');
        $retrait_usd= DB::table("transactions")->where(['branche_id'=>$userInfo->branche_id,'currency'=>'USD','category'=>'retrait'])->sum('amount');
        $depot_cdf= DB::table("transactions")->where(['branche_id'=>$userInfo->branche_id,'currency'=>'CDF','category'=>'depot'])->sum('amount');
        $depot_usd= DB::table("transactions")->where(['branche_id'=>$userInfo->branche_id,'currency'=>'USD','category'=>'depot'])->sum('amount');
        $transfert_cdf= DB::table("transactions")->where(['branche_id'=>$userInfo->branche_id,'currency'=>'CDF','category'=>'transfert'])->sum('amount');
        $transfert_usd= DB::table("transactions")->where(['branche_id'=>$userInfo->branche_id,'currency'=>'USD','category'=>'transfert'])->sum('amount');
      
        $customers = Customer::count();

        return view('backend.dashboard.manager',compact('transactions','customers','retrait_cdf','retrait_usd','depot_cdf','depot_usd','transfert_cdf','transfert_usd','solde_cdf','solde_usd'));
    }
}
