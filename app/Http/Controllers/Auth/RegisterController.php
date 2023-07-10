<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DateController;
use App\Http\Controllers\GenerateIdController;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Wallet;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create(Request $request){
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
            'phone_number' => ['required', 'string', 'min:9'],
            'role' => ['required', 'string', 'max:255'],
        ]);

        $date = new DateController;
        $today = $date->todayDate();
        
        $new_user = User::insert([
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'role_name' => $request['role'],
            'password_salt' => $request['password'],
            'created_at' => $today,
            'updated_at' => $today,
            'password' => Hash::make($request['password']),
        ]);

        if ($new_user) {
            if ($request['role'] == "Cashier") {
 
            }
    
            elseif ($request['role'] == "Manager") {
    
            }
    
            elseif ($request['role'] == "Admin") {
                $user = User::where('phone_number',$request['phone_number'])->first();
                $user_id = $user->id;

                $userInfo = UserInfo::where('user_id',Auth::user()->id)->first();
                $branche_id = $userInfo->branche_id;

                $info = [
                    'user_id' => $user_id,
                    'branche_id' => $branche_id,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'phone_number' => $user->phone_number,
                    'created_at' => $today,
                    'updated_at' => $today,
                ];
                $newinfo = UserInfo::insert($info);
                if ($newinfo) {
                    $acnumber = new GenerateIdController;
                    $walletDebitCDF = $acnumber->walletDebitCDF();
                    $walletDebitUSD = $acnumber->walletDebitUSD();
                    $walletCreditCDF = $acnumber->walletCreditCDF();
                    $walletCreditUSD = $acnumber->walletCreditUSD();
                    $data = [
                        [
                            'w_code' => $walletCreditCDF,
                            'amount' => 2000000,
                            'currency' => "CDF",
                            'w_type' => "credit",
                            'created_at' => $today,
                            'updated_at' => $today
                        ],
                        [
                            'w_code' => $walletCreditUSD,
                            'amount' => 5000,
                            'currency' => "USD",
                            'w_type' => "credit",
                            'created_at' => $today,
                            'updated_at' => $today
                        ],
                        [
                            'w_code' => $walletDebitCDF,
                            'amount' => 2000000,
                            'currency' => "CDF",
                            'w_type' => "debit",
                            'created_at' => $today,
                            'updated_at' => $today
                        ],
                        [
                            'w_code' => $walletDebitUSD,
                            'amount' => 5000,
                            'currency' => "USD",
                            'w_type' => "debit",
                            'created_at' => $today,
                            'updated_at' => $today
                        ],
                    ];
                    Wallet::insert($data);
                }
            }
        }

    }

    public function index(){
        return view('auth.register');
    }
}
