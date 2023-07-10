<?php

namespace Database\Seeders;

use App\Http\Controllers\DateController;
use App\Http\Controllers\GenerateIdController;
use App\Models\Branch;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = new DateController;
        $today = $date->todayDate();
        
        $new_user = User::insert([
            'email' => "barahenock@gmail.com",
            'phone_number' => "243828584688",
            'role_name' => "Admin",
            'password_salt' => "12345",
            'created_at' => $today,
            'updated_at' => $today,
            'password' => Hash::make("12345"),
        ]);

        if ($new_user) {
            $user = User::where('phone_number',"243828584688")->first();
            $user_id = $user->id;

            $branch = Branch::first();
            $branche_id = $branch->id;

            $info = [
                'user_id' => $user_id,
                'branche_id' => $branche_id,
                'firstname' => "Henock",
                'lastname' => "BARAKAEL",
                'phone_number' => "243828584688",
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
