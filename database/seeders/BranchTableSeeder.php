<?php

namespace Database\Seeders;

use App\Http\Controllers\DateController;
use App\Http\Controllers\GenerateIdController;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class BranchTableSeeder extends Seeder
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
        $code_agence = new GenerateIdController;
        $bcode = $code_agence->password();
        Branch::create([
            'bcode'   => $bcode,
            'bname'   => "Agence de Gombe",
            'bemail'   => "gombe@emalafintech.net",
            'btownship'   => "Gombe",
            'bcity'   => "Kinshasa",
            'bphone'   => "243828584688",
            'created_at'   => $today,
            'updated_at'   => $today,
        ]);
    }
}
