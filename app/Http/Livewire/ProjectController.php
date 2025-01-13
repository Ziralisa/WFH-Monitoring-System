<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Livewire\Component;

class ProjectController extends  Component
{
    // Show projects and their tasks
    public function index()
    {
        $projects = Project::with('tasks')->get();
        return view('livewire.task-management.projects', compact('projects'));
    }

    // Store a new project
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Project::create($request->only(['name', 'description']));

        return redirect()->back()->with('success', 'Project created successfully!');
    }

    // Store a new task under a project
    public function storeTask(Request $request, $projectId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'task_status' => 'required|in:To Do,In Progress,Done,Stuck',
            'task_priority' => 'required|in:Low,Medium,High',
            'task_assign' => 'nullable|string',
            'task_description' => 'nullable|string',
        ]);

        Task::create([
            'project_id' => $projectId,
            'sprint_id' => $request->sprint_id, // optional, handle accordingly
            'name' => $request->name,
            'task_status' => $request->task_status,
            'task_priority' => $request->task_priority,
            'task_assign' => $request->task_assign,
            'task_description' => $request->task_description,
        ]);

        return redirect()->back()->with('success', 'Task created successfully!');
    }
}
