<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Sprint;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;

class SprintController extends Component
{
    public $commentContent = '';
    public $taskId;

    protected $rules = [
        'commentContent' => 'nullable|string|min:5|max:500',
    ];


    public function setTaskId($id){
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
        $task->task_assign = $request->task_assign;
        $task->save();

        return redirect()->back()->with('success', 'Task assigned successfully');
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
        return view('livewire.task-management.backlog', [
            'sprints' => Sprint::all(),
            'users' => User::all(),
        ]);
    }
}
