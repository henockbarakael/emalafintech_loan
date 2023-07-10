<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DateController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\GenerateIdController;
use App\Http\Controllers\VerifyNumberController;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    public function index(){
        $customers = Customer::join('users','customers.user_id','users.id')
        ->select('users.status','users.avatar','users.password_salt','customers.*')->get();
        return view('backend.customer.index', compact('customers'));
    }

    public function add(Request $request){
        $request->validate([
            'firstname'   => 'required|string|max:255',
            'lastname'   => 'required|string|max:255',
            'phone_number'   => 'required|string|max:255',
            'ville'   => 'required|string|max:255',
            'pays'   => 'required|string|max:255',
            'adresse'   => 'required|string|max:255',
        ]);

        $date = new DateController;
        $today = $date->todayDate();

        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $phone= new VerifyNumberController;
        $phone_number = $phone->verify_number($request->phone_number);
        $created_by = Auth::user()->id;
        $role_name = "Customer";
        $pin = new GenerateIdController;
        $password = $pin->password();

        $account = new AccountController;
        $actype = "current";

        # Vérification de l'existence du numéro de téléphone dans la table users
        $verify = $this->verifyUser($phone_number);
     
        if ($verify["status"]==200) {
            $user = User::where('phone_number',$phone_number)->first();
            $user_id = $user->id;
            $customer = [
                'user_id' => $user_id,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone_number' => $phone_number,
                'city' => $request->ville,
                'country' => $request->pays,
                'address' => $request->adresse,
                'created_by' => $created_by,
                'created_at' => $today,
                'updated_at' => $today,
            ];
            $newCustomer = Customer::insert($customer);
            if ($newCustomer) {
                $result = Customer::where('phone_number',$phone_number)->first();
                $customer_id = $result->id;
                $account->compte($customer_id,$actype);
            }

            Alert::success('Succès', 'Client créé avec succès!');
            return redirect()->route('admin.customer.all');
        }
        else {
            $user = [
                'password'  => Hash::make($password),
                'password_salt'  => $password,
                'phone_number' => $phone_number,
                'avatar' => "user.png",
                'role_name' => $role_name,
                'created_at' => $today,
                'updated_at' => $today,
            ];
    
            $newUser = User::insert($user);

            if ($newUser) {
                $user = User::where('phone_number',$phone_number)->first();
                $user_id = $user->id;
                $customer = [
                    'user_id' => $user_id,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'phone_number' => $phone_number,
                    'city' => $request->ville,
                    'country' => $request->pays,
                    'address' => $request->adresse,
                    'created_by' => $created_by,
                    'created_at' => $today,
                    'updated_at' => $today,
                ];
                $newCustomer = Customer::insert($customer);
                if ($newCustomer) {
                    $result = Customer::where('phone_number',$phone_number)->first();
                    $customer_id = $result->id;
                    $account->compte($customer_id,$actype);
                }
                Alert::success('Succès', 'Client créé avec succès!');
                return redirect()->route('admin.customer.all');

            }
        }
    }


    public function edit(Request $request){
        $request->validate([
            'lastname'      => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'phone_number' => 'required|string|min:9|max:12',
            'adresse' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $phone_number = $request->phone_number;
        $lastname = $request->lastname;
        $firstname = $request->firstname;
        $adresse = $request->adresse;
        $ville = $request->city;
        $pays = $request->country;

        $date = new DateController;
        $today = $date->todayDate();
        DB::beginTransaction();
        try {
            DB::table('customers')->where('phone_number',$phone_number)->update([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone_number' => $phone_number,
                'city' => $ville,
                'country' => $pays,
                'address' => $adresse,
                'updated_at'   => $today,
            ]);
        
            DB::commit();
            Alert::success('Succès', 'Infomation mise à jour avec succès !');
            return redirect()->route('admin.customer.all');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::success('Succès', 'Une erreur est survenue lors de la modification du client!');
            return redirect()->route('admin.customer.all');
        }


    }

    public function delete(Request $request){
        $customer_id = $request->id;
        $customer = Customer::where('id',$customer_id)->first();
        $user_id = $customer->user_id;
        DB::beginTransaction();
        try {
            DB::table('users')->delete($user_id);
            DB::table('customers')->delete($customer_id);
        
            DB::commit();
            Alert::success('Succès', 'Client supprimé avec succès !');
            return redirect()->route('admin.customer.all');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::success('Succès', 'Une erreur est survenue lors de la suppression du client!');
            return redirect()->route('admin.customer.all');
        }
        
    }

    public function verifyUser($phone_number){
        $user = User::where('phone_number',$phone_number)->count();
        if ($user == 0) {
            return ['status' => 404,'message' => 'Utilisateur non trouvé'];
        }
        else {
            return ['status' => 200,'message' => 'Utilisateur trouvé'];
        }
    }

}
