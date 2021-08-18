<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //Get all tasks
    public function index()
    {
        //Get all the tasks and return in json format with status code
        $tasks = Task::all();
        return response()->json(['tasks'=>$tasks], 200);
    }


    //Store tasks into the database
    public function store(Request $request)
    {   //Validating the form
        $request->validate([
            'title' => 'required|max:191',
            'content' => 'required',
            'status' => 'required',
        ]);

        //Create New Task, Store the task and return in json format with status code
        $task = new Task;
        $task->title = $request->title;
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();
        return response()->json(['message'=>'Task Added Successfully'], 200); 
    }
}
