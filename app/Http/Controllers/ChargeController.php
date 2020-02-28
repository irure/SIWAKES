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
        $and=true;
        $charge=Auth::user()->charges()->where('charge_id',$charge_id)->first();
        
        $charge_old = $charge->charge;
        $user_id = $charge->user_id;
        $request->charge = base64_decode($request->charge);
        
        $userCharges = Task::when($and, function($q) use($user_id,$charge_old){
            $q->where('user_id', $user_id)
            ->where('charge', $charge_old)
            ;})->get();
        
        foreach ($userCharges as $userCharge) {
            $userCharge->charge = $request->charge;
            $userCharge->save();
        }
        
        $charge->charge =$request->charge;
        $charge->save();
    }
    
    public function getGraph(){
        
        $and=true;
        $charges = Auth::user()->charges()->get('charge')->all();
        //$charges = json_decode(json_encode($charges), true);
        $user_id=Auth::id();

        //$data[];
        $charges = array_column($charges, 'charge');
        foreach($charges as $key => $value){
            $data[$value]=0;
            $userCharges = Task::when($and, function($q) use($user_id,$value){
                $q->where('user_id', $user_id)
                ->where('charge', $value)
            ;})->get();
            foreach($userCharges as $userCharge){
                $data[$value] += $userCharge->howlong * $userCharge->howtimes;
            }
        }
        return $data;
    }
    
    public function getGraph2(){
        
        $and=true;
        $charges = Auth::user()->charges()->get('charge')->all();
        
        $user_id=Auth::id();

        //$data[];
        $charges = array_column($charges, 'charge');
        foreach($charges as $key => $value){
            $data[$value]=0;
            $userCharges = Task::when($and, function($q) use($user_id,$value){
                $q->where('user_id', $user_id)
                ->where('charge2', $value)
            ;})->get();
            foreach($userCharges as $userCharge){
                $data[$value] += $userCharge->howlong * $userCharge->howtimes;
            }
        }
        return $data;
    }
}
