<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Sprint;
use App\Models\Task;
use App\Models\TaskLog;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class SprintController extends Component
{
    public $commentContent = '';
    public $taskId;
    public $commentId;

    protected $rules = [
        'commentContent' => 'nullable|string|min:5|max:500',
    ];

    public function setTaskId($id)
    {
        $this->taskId = $id;
    }
    public function getTasksByProject($projectId, $sprintId)
    {
        // Get all task IDs already associated with the sprint
        $existingTaskIds = DB::table('sprint_task')->where('sprint_id', $sprintId)->pluck('task_id')->toArray();

        // Fetch tasks that are part of the project but not already assigned to the sprint
        $tasks = Task::where('project_id', $projectId)
            ->whereNotIn('id', $existingTaskIds)
            ->get(['id', 'name']);

        return response()->json($tasks);
        dd(request()->all());
    }

    public function storeComment(Task $task)
    {
        $validatedcontent = $this->validate([
            'commentContent' => 'required|string|max:500',
        ]);

        // Store the comment
        $comment = new Comment();
        $comment->task_id = $this->taskId;
        $comment->user_id = auth()->id();
        $comment->content = $validatedcontent['commentContent'];
        $comment->save();

        flash()->success('Comment added successfully!');

        return redirect()->route('backlog.show');
    }

    public function editComment($commentId)
    {
        $comment = Comment::find($commentId);

        if ($comment) {
            $this->commentId = $comment->id;
            $this->commentContent = $comment->content;
        } else {
            session()->flash('error', 'Comment not found.');
        }
    }
    public function updateComment()
    {
        $validated = $this->validate([
            'commentContent' => 'required|string|max:500',
        ]);

        $comment = Comment::findOrFail($this->commentId);

        $comment->content = $validated['commentContent'];
        $comment->save();

        flash()->success('Comment updated successfully!');
        return redirect()->route('backlog.show');
    }

    public function deleteComment($commentid)
    {
        // Find and delete the comment
        $comment = Comment::find($commentid);

        if ($comment) {
            $comment->delete();

            // Optionally refresh the comments list
            $this->comments = Comment::latest()->get();

            // Provide feedback to the user
            flash()->success('Comment removed successfully!');
            // Redirect to the dashboard
            return redirect()->route('backlog.show');
        } else {
            flash()->error('Comment not found!');
        }
    }

    public function storeSprint()
    {
        //dd(request()->all());

        // Validate the incoming data
        $validated = request()->validate([
            'name' => 'required|string|max:50',
            'desc' => 'nullable|string|max:255',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after_or_equal:startdate',
        ]);

        //dd($request->validate());
        Sprint::create($validated);

        return redirect()->route('backlog.show')->with('success', 'Sprint added successfully!');
    }

    public function storeTask(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'sprint_id' => 'required|exists:sprints,id',
            'project_id' => 'required|exists:projects,id',
            'task_id' => 'required|exists:tasks,id', // Ensure task_id exists in the tasks table
            'task_description' => 'nullable',
            'task_priority' => 'required|in:Low,Medium,High',
            'task_status' => 'required|in:To Do,In Progress,Done,Stuck',
            'task_assign' => 'nullable|exists:users,id', // task_assign can be null or must exist in users table
        ]);

        try {
            // Find the task by its ID
            $task = Task::where('id', $validated['task_id'])->firstOrFail(); // Ensure the task exists for the given project_id
            // Update the task's attributes

            $task->update([
                'task_priority' => $validated['task_priority'],
                'task_status' => $validated['task_status'],
                'task_assign' => $validated['task_assign'] ?? null,
                'task_description' => $validated['task_description'],

                //isset($validated['task_assign']) ? $validated['task_assign'] : null,
            ]);

            $sprint = Sprint::findOrFail($validated['sprint_id']);
            // Insert the task_id and sprint_id into the sprint_task  table
            DB::table('sprint_task')->insert([
                'sprint_id' => $validated['sprint_id'],
                'task_id' => $validated['task_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('backlog.show')->with('success', 'Task updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->route('backlog.show')
                ->with('error', 'Failed to update the task: ' . $e->getMessage());
        }
    }

    protected $listeners = ['taskAdded' => 'reloadTasks'];
    public function reloadTasks()
    {
        $selectedProjectId = request()->route('projectId');
        if ($selectedProjectId) {
            $tasks = Task::where('project_id', $selectedProjectId)->get();
            $this->emit('tasksUpdated', $tasks); // Send tasks data to the front-end
        } else {
            session()->flash('error', 'No project selected!');
        }
    }

    public function assignTask(Request $request, Task $task)
    {
        if ($request->has('task_assign')) {
            $task->assignedUser()->associate(User::find($request->input('task_assign')));
            $task->save();

            return redirect()->route('backlog.show')->with('success', 'Task assigned successfully.');
        }

        return redirect()->route('backlog.show')->with('error', 'Failed to assign the task.');
    }

    //EDIT AND DELETE SPRINT
    public function destroySprint(Sprint $sprint)
    {
        $sprint->delete();

        return redirect()->back()->with('success', 'Sprint deleted successfully!');
    }

    public function updateSprint(Request $request, Sprint $sprint)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string|max:255',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after_or_equal:startdate',
        ]);

        $sprint->update($validated);

        return redirect()->back()->with('success', 'Sprint updated successfully!');
    }

    public function updateTaskStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_status' => 'required|in:To Do,In Progress,Done,Stuck',
        ]);

        $task->update($validated);

        TaskLog::create([
            'task_id' => $task->id,
            'status' => $validated['task_status'],
        ]);

        return response()->json(['success' => true]);
    }

    public function render()
    {
        $selectedProjectId = request()->route('projectId');
        $tasks = Task::where('project_id', $selectedProjectId)->get();
        $projects = Project::all();

        return view('livewire.task-management.backlog', [
            'sprints' => Sprint::all(),
            'staff' => User::role('staff')->get(),
            'projects' => $projects,
            'tasks' => $tasks,
        ]);
    }
}
