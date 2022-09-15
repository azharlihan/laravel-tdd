<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::all();
        $editableTask = null;

        if ($request->has('id') and $request->input('action') == 'edit') {
            $editableTask = Task::find($request->input('id'));
        }

        return view('tasks.index', compact('tasks', 'editableTask'));
    }

    public function store(Request $request)
    {
        $taskData = $request->validate([
            'name'        => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        Task::create($taskData
    );

        return back();
    }

    public function update(Task $task, Request $request)
    {
        $taskData = $request->validate([
            'name'        => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        $task->update($taskData);

        return redirect('/tasks');
    }
}
