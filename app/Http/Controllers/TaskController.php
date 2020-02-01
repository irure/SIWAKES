<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function get(){
        return response()->json(Auth::user()->tasks()->get());
    }
    
    public function post(Request $request){
        $task = new Task();
        $task->task = $request->task;
        $task->user_id = Auth::id();
        $task->save();
        return response("OK", 200);
    }
    
    public function delete($id){
        Task::find($id)->delete();
        return response("OK", 200);
    }
    
    public function update(Request $request,$id){
        $task = Task::find($id);
        $task->task = $request->task;
        $task->save();
        return response("OK", 200);
    }
}
