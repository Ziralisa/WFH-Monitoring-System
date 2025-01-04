<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Sprint;
use App\Models\User;

class TaskController extends Controller
{
    public function create()
    {
        $sprints = Sprint::all(); 
        $users = User::all(); 
        return view('livewire.task-management.backlog', compact('sprints', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sprint_id' => 'required|exists:sprints,id',
            'name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'task_priority' => 'required|in:Low,Medium,High',
            'task_status' => 'required|in:To Do,In Progress,Done,Stuck',
            'task_assign' => 'nullable|exists:users,id',
        ]);

        $validated['task_assign'] = $validated['task_assign'] ?? null;

        try {
            Task::create($validated);
            return redirect()->route('tasks.create')->with('success', 'Task created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('tasks.create')->with('error', 'Failed to save the task: ' . $e->getMessage());
        }
    }

    public function assignTask(Request $request, Task $task)
    {
        $task->task_assign = $request->task_assign;
        $task->save();

        return redirect()->back()->with('success', 'Task assigned successfully');
    }
    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_status' => 'required|in:To Do,In Progress,Done,Stuck',
        ]);

        $task->update($validated);

        return response()->json(['success' => true]);
    }

}