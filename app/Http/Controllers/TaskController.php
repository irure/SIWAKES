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
        $task->task = $request->task;
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
        $task->task = $request->task;
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
}
