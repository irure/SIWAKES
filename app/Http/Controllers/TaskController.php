<?php

namespace App\Http\Controllers;
use App\Task;
use App\Charge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //
    public function get(){
        return response()->json(Auth::user()->tasks()->get());
    }
    
    public function post(Request $request){
        $task = new Task();
        $task->task = urldecode($request->task);
        $task->howtimes = 1;
        $task->howlong = 30;
        $task->charge = '気づいた方';
        $task->user_id = Auth::id();
        $task->save();
        return response("OK", 200);
    }
    
    public function delete($id){
        Task::find($id)->delete();
        return response("OK", 200);
    }
    
    public function taskUpdate(Request $request,$id){
        $task = Task::find($id);
        $task->task = base64_decode($request->task);
        $task->save();
        return response("OK", 200);
    }
    
    public function howlongUpdate(Request $request,$id){
        $task = Task::find($id);
        $task->howlong = $request->howlong;
        $task->save();
        return response("OK", 200);
    }
    
    public function howtimesUpdate(Request $request,$id){
        $task = Task::find($id);
        $task->howtimes = $request->howtimes;
        $task->save();
        return response("OK", 200);
    }
    
    public function chargeUpdate(Request $request,$id){
        $task = Task::find($id);
        $task->charge = $request->charge;
        $task->save();
        return response("OK", 200);
    }
    
    public function chargeUpdate2(Request $request,$id){
        $task = Task::find($id);
        $task->charge2 = $request->charge2;
        $task->save();
        return response("OK", 200);
    }
    
    public function setRating(Request $request){
        $user = Auth::user();
        $user->rating = $request->rating;
        $user->save();
        return response("OK", 200);
    }
    
    public function setRating2(Request $request){
        $user = Auth::user();
        $user->rating2 = $request->rating2;
        $user->save();
        return response("OK", 200);
    }
    
    public function getRating(){
        $user = Auth::user();
        return $user->rating;
    }
    
    public function getRating2(){
        $user = Auth::user();
        return $user->rating2;
    }
    
    public function getText(){
        $user = Auth::user();
        $text = '仕分けを完了しました！満足度は'.str_repeat('★',$user->rating).str_repeat('☆',5-$user->rating).'でした！https://siwakes.site';
        return $text;
    }
    
    public function getText2(){
        $user = Auth::user();
        $text = '2回目の仕分けを完了しました！満足度は'.str_repeat('★',$user->rating).str_repeat('☆',5-$user->rating).'から'.
        str_repeat('★',$user->rating2).str_repeat('☆',5-$user->rating2).'になりました！https://siwakes.site';
        return $text;
    }
    
    public function setPart(){
        $user = Auth::user();
        $user->part=1;
        $user->save();
        
        $and=true;
        $user_id = $user->id;
        
        $userCharges = Task::when($and, function($q) use($user_id){
            $q->where('user_id', $user_id)
            ;})->get();
        
        foreach ($userCharges as $userCharge) {
            $userCharge->charge2 = $userCharge->charge;
            $userCharge->save();
        }
        
        return response("OK", 200);
    }
    
    public function setPartFalse(){
        $user = Auth::user();
        $user->part=0;
        //return $user;
        $user->save();
        return response("OK", 200);
    }
    
    public function getPart(){
        $user = Auth::user();
        return $user->part;
    }
}
