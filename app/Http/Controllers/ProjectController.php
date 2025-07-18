<?php

namespace App\Http\Controllers;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class ProjectController extends Component
{
    //----------------DISPLAY PROJECTS------------------
    public function index(Request $request)
{
    $user = auth()->user();
    $sort = $request->query('sort', 'latest');

    // Apply sorting logic before returning view
    $projectsQuery = Project::with('tasks')
        ->where('company_id', $user->company_id);

    if ($sort === 'oldest') {
        $projectsQuery->orderBy('created_at', 'asc');
    } else {
        $projectsQuery->orderBy('created_at', 'desc');
    }

    $projects = $projectsQuery->get();

    return view('livewire.task-management.projects', compact('projects'));
}

    //----------------STORE NEW PROJECT------------------
    public function storeProject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

 Project::create([
            'name' => $request->name,
            'description' => $request->description, 
            'start_date' => $request->start_date, 
            'end_date' => $request->end_date,
            'company_id' => auth()->user()->company_id,
        ]);
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


    //----------------UPDATE TASK------------------
    public function updateTask(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
        ]);

        $task->update($validated);

        return redirect()->back()->with('success', 'Task updated successfully!');
    }

    //----------------DELETE TASK------------------
    public function destroyTask(Task $task)
    {
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully!');
    }

    //----------------UPDATE PROJECT------------------
    public function updateProject(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $project->update($validated);

        return redirect()->back()->with('success', 'Project updated successfully!');
    }

    //----------------DELETE PROJECT------------------
    public function destroyProject(Project $project)
    {
        $project->delete();

        return redirect()->back()->with('success', 'Project deleted successfully!');
    }
}