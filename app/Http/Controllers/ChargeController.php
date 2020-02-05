<?php

namespace App\Http\Controllers;

use App\User;
use App\Charge;
use App\Task;
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
    
    public function chargeListUpdate(Request $request,$charge_id){
        //$charge = Auth::user()->user_id()->charge_id()->find($charge_id);
        //$charge = Auth::whereHas('charges', function($q){
         //   $q->where('charge_id', $charge_id);
        //})->get();
        //$charge = Auth::whereHas('charges', function($q){
        //    $q->where('charge_id', $charge_id);
        //})->get();
        
        $and=true;
        $charge=Auth::user()->charges()->where('charge_id',$charge_id)->first();
        
        $charge_old = $charge->charge;
        $user_id = $charge->user_id;
        
        $userCharges = Task::when($and, function($q) use($user_id,$charge_old){
            $q->where('user_id', $user_id)
            ->where('charge', $charge_old)
            ;
        })->get();
        
        foreach ($userCharges as $userCharge) {
            $userCharge->charge = $request->charge;
            $userCharge->save();
        }
        
        $charge->charge =$request->charge;
        $charge->save();
    }
}
