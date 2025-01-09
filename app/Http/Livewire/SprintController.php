<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Sprint;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Spatie\Permission\Models\Role;

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

        $this->reset(['commentContent']); 
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

    /**
     * Store a new sprint in the database.
     */
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
        // Create and save the sprint
        Sprint::create($validated);

        return redirect()->route('backlog.show')->with('success', 'Sprint added successfully!');
    }

    public function storeTask(Request $request)
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
            return redirect()->route('backlog.show')->with('success', 'Task created successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->route('backlog.show')
                ->with('error', 'Failed to save the task: ' . $e->getMessage());
        }
    }

    public function assignTask(Request $request, Task $task)
    {
        // Ensure the user has been selected
        if ($request->has('task_assign')) {
            // Assign the task to the user
            $task->assignedUser()->associate(User::find($request->input('task_assign')));
            $task->save();
    
            // Redirect back with success message (or you can just reload the page)
            return redirect()->route('backlog.show')->with('success', 'Task assigned successfully.');
        }
    
        return redirect()->route('backlog.show')->with('error', 'Failed to assign the task.');
    }
    
    public function updateTaskStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_status' => 'required|in:To Do,In Progress,Done,Stuck',
        ]);

        $task->update($validated);

        return response()->json(['success' => true]);
    }

    public function render()
    {
        // Check if the daily log view is requested
        if (request()->routeIs('daily.show')) {
            // Fetch sall tasks updated in the last 7 days with status "In Progress"
            $taskLogs = Task::with(['assignedUser'])
                ->where('updated_at', '>=', now()->subWeek())  // Get tasks updated in the last week
                ->whereIn('task_status', ['In Progress', 'Done', 'Stuck'])   // Filter by "In Progress" status
                ->orderBy('updated_at', 'desc')
                ->get()
                ->groupBy(function ($task) {
                    return $task->updated_at->format('Y-m-d'); // Group tasks by date
                });
    
            // Return the daily task log view
            return view('livewire.task-management.components.daily-task-page', [
                'taskLogs' => $taskLogs,
            ]);
        }
    
        // Default to backlog view
        return view('livewire.task-management.backlog', [
            'sprints' => Sprint::all(),
            'staff' => User::role('staff')->get(),
        ]);
    }
    
}
