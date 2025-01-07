<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\Sprint;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Component
{
    public $sprints;
    public $staff;
    public $taskName;
    public $taskDescription;
    public $taskPriority = 'Low';
    public $taskStatus = 'To Do';
    public $taskAssign;
    public $taskId;

    // Mounting data to component
    public function mount()
    {
        $this->sprints = Sprint::all(); // Get all sprints
        $this->staff = User::role('staff')->get(); // Get users with 'staff' role
    }

    // Task creation method
    public function createTask()
    {
        $this->validate([
            'taskName' => 'required|string|max:255',
            'taskPriority' => 'required|in:Low,Medium,High',
            'taskStatus' => 'required|in:To Do,In Progress,Done,Stuck',
            'taskAssign' => 'nullable|exists:users,id',
        ]);

        // Task creation logic
        $task = Task::create([
            'sprint_id' => $this->taskAssign, // Assuming you want to assign to sprint_id for now
            'name' => $this->taskName,
            'task_description' => $this->taskDescription,
            'task_priority' => $this->taskPriority,
            'task_status' => $this->taskStatus,
            'task_assign' => $this->taskAssign,
        ]);

        session()->flash('message', 'Task created successfully!');

        // Reset fields after task creation
        $this->resetFields();
    }

    // Method for assigning task to staff
    public function assignTask($taskId)
    {
        $this->taskId = $taskId; // Set task to be assigned
    }

    // Assign staff to task
    public function saveAssignedTask()
    {
        $this->validate([
            'taskAssign' => 'required|exists:users,id',
        ]);

        $task = Task::find($this->taskId);

        if ($task) {
            $task->update(['user_id' => $this->taskAssign]);
            session()->flash('message', 'Task assigned successfully!');
            $this->resetFields();
        } else {
            session()->flash('error', 'Task not found!');
        }
    }

    // Method to update task status
    public function updateStatus($taskId, $status)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->update(['task_status' => $status]);
            session()->flash('message', 'Task status updated successfully!');
        }
    }

    // Reset the input fields
    public function resetFields()
    {
        $this->taskName = '';
        $this->taskDescription = '';
        $this->taskPriority = 'Low';
        $this->taskStatus = 'To Do';
        $this->taskAssign = null;
    }

    public function render()
    {
        return view('livewire.task-management');
    }
}
