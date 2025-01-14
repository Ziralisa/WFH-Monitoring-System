<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class ProjectController extends Component
{
    // Display projects
    public function index()
    {
        $projects = Project::with('tasks')->get();
        return view('livewire.task-management.projects', compact('projects'));
    }

    //----------------STORE NEW PROJECT------------------
    public function storeProject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Project::create($request->only(['name', 'description']));

        return redirect()->back()->with('success', 'Project created successfully!');
    }

    //----------------STORE NEW TASK------------------
    public function storeTask(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
        ]);
    
        Task::create($validated);
    
        return redirect()->back()->with('success', 'Task created successfully!');
    }
    
}
