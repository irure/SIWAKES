<?php

namespace App\Http\Controllers;

use App\User;
use App\Charge;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;

class ChargeController extends Controller
{
    //
    public function get(){
        return response()->json(Auth::user()->charges()->get());
    }
    
    public function chargeListUpdate(Request $request,$id){
        
    }
}
