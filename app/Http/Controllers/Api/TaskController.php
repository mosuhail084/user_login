<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    
    public function addTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id', // Validate that user_id exists in users table
            'task' => 'required|string',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $task = new Task([
            'user_id' => $request->user_id,
            'task' => $request->task,
        ]);
        $task->save();
    
        return response()->json([
            'task' => $task,
            'status' => 1,
            'message' => 'Successfully created a task',
        ]);
    }
    
    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|integer|exists:tasks,id',
            'status' => 'required|in:pending,done',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $task = Task::findOrFail($request->task_id);
        $task->status = $request->status;
        $task->save();
    
        $message = $task->status === 'done' ? 'Marked task as done' : 'Marked task as pending';
    
        return response()->json([
            'task' => $task,
            'status' => 1,
            'message' => $message,
        ]);
    }
}
