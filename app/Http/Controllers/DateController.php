<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DateController extends Controller
{
    public function todayDate(){
        Carbon::setLocale('fr');
        $todayDate = Carbon::now()->format('Y-m-d H:i:s');
        return $todayDate;
    }
}
