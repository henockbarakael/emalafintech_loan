<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DateController;
use App\Http\Controllers\VerifyNumberController;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo(){
        if( Auth()->user()->role_name == "Admin"){
            return route('admin.dashboard');
        }
        elseif( Auth()->user()->role_name == "Manager"){
            return redirect()->route('manager.dashboard');
        }
        elseif( Auth()->user()->role_name == "Cashier"){
            return redirect()->route('cashier.dashboard');
        }
        elseif( Auth()->user()->role_name == "Customer"){
            return redirect()->route('customer.dashboard');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(){
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'telephone' => 'required|string|min:9|max:12',
            'password' => 'required|string|min:4|max:8',
        ]);
        $verify_number = new VerifyNumberController;
        $telephone = $verify_number->verify_number($request->telephone);
        $pin = $request->password;
        $date = new DateController;
        $todayDate = $date->todayDate();

        $user_status = [
                'user_status' => 'En ligne',
        ];
        
        $clientIP = request()->ip(); 

        if (Auth::attempt(['phone_number'=>$telephone,'password'=>$pin])) {
            if (Auth::user()->role_name == "Root") {
                DB::table('users')->where('phone_number',$telephone)->update($user_status);
                Toastr::success('Connexion réussie :)','Success');
                return redirect()->route('root.dashboard');
            }
            elseif (Auth::user()->role_name == "Admin") {
                DB::table('users')->where('phone_number',$telephone)->update($user_status);
                Toastr::success('Connexion réussie :)','Success');
                return redirect()->route('admin.dashboard');
                 
            }
            elseif (Auth::user()->role_name == "Manager") {
                DB::table('users')->where('phone_number',$telephone)->update($user_status);
                Toastr::success('Connexion réussie :)','Success');
                return redirect()->route('manager.dashboard');
                 
            }
            elseif (Auth::user()->role_name == "Cashier") {
                DB::table('users')->where('phone_number',$telephone)->update($user_status);
                Toastr::success('Connexion réussie :)','Success');
                return redirect()->route('cashier.dashboard');
                 
            }
        }
        else{
            Toastr::error('Erreur, Nom d\'utilisateur ou mot de passe incorrect:)','Error');
            return redirect('login');
        }

    }

    public function logout()
    {
        $user = Auth::User();
        Session::put('users', $user);
        $user=Session::get('users');

        $currentTime = Carbon::now();
        $date = $currentTime->toDateTimeString();

        $clientIP = request()->ip(); 

        $user_status = [
            'user_status' => 'Hors ligne',
        ];

        DB::table('users')->where('phone_number',$telephone)->update($user_status);

        Auth::logout();
        Toastr::success('Déconnecté avec succès :)','Success');
        return redirect('login');
    }
}
