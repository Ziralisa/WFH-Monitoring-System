<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Carbon\Carbon;
use Livewire\Component;

class DailyTask extends Component
{
    public $todoTasksForTable = [];
    public $completedTasksForTable = [];
    public $unassignedTasks = [];
    public $assignedTasks = [];
    public $selectedTaskId;
    protected $taskLogs = [];

    public function mount()
    {
        // Load tasks when the component is mounted
        $this->loadTasksForCurrentWeek();
        $this->loadUnassignedAndAssignedTasks();
        $this->loadTaskLogs();
    }

    public function loadTasksForCurrentWeek()
    {
        // Get the start and end of the current week
        $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
        $endOfWeek = Carbon::now()->endOfWeek()->toDateString();

        // Fetch tasks for the current week
        $todoTasks = Task::whereBetween('todo_date', [$startOfWeek, $endOfWeek])->get();
        $completedTasks = Task::whereBetween('completed_date', [$startOfWeek, $endOfWeek])->get();

        // Group tasks by day name for both To-Do and Completed
        $todoTasksByDay = $todoTasks->groupBy(function ($task) {
            return Carbon::parse($task->todo_date)->format('l'); // "Monday", "Tuesday", etc.
        });

        $completedTasksByDay = $completedTasks->groupBy(function ($task) {
            return Carbon::parse($task->completed_date)->format('l'); // "Monday", "Tuesday", etc.
        });

        // Prepare tasks for each weekday column
        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $this->todoTasksForTable = [];
        foreach ($weekDays as $day) {
            $this->todoTasksForTable[$day] = $todoTasksByDay[$day] ?? collect(); // Ensure empty collection if no tasks
        }

        $this->completedTasksForTable = [];
        foreach ($weekDays as $day) {
            $this->completedTasksForTable[$day] = $completedTasksByDay[$day] ?? collect(); // Ensure empty collection if no tasks
        }
    }

    public function loadUnassignedAndAssignedTasks()
    {
        $this->unassignedTasks = Task::where('task_assign', auth()->id())->whereNull('todo_date')->get();
        $this->assignedTasks = Task::where('task_assign', auth()->id())->whereNull('completed_date')->whereNotNull('todo_date')->get();
    }

    public function loadTaskLogs()
{
    $taskLogs = Task::with(['assignedUser'])
        ->where('updated_at', '>=', now()->subWeek())
        ->whereIn('task_status', ['In Progress', 'Done', 'Stuck'])
        ->orderBy('updated_at', 'desc')
        ->get()
        ->groupBy(function ($task) {
            return $task->updated_at->format('Y-m-d');
        });

    $this->taskLogs = $taskLogs;
}

    public function addTodoTaskToday()
    {

        if ($this->selectedTaskId) {
            $task = Task::find($this->selectedTaskId);

            if ($task) {
                $task->todo_date = now();
                $task->task_status = 'In Progress';
                $task->save();

                return redirect()->route('daily.show')->with('success', 'Added task to-do task for today successfully.');
            }
        } else {
            session()->flash('error', 'Please select a task.');
        }
    }

    public function addCompletedTaskToday()
    {

        if ($this->selectedTaskId) {
            $task = Task::find($this->selectedTaskId);

            if ($task) {
                $task->completed_date = now();
                $task->task_status = 'Done';
                $task->save();

                // Success message
                return redirect()->route('daily.show')->with('success', 'Added task completed for today successfully.');
            } else {
                session()->flash('error', 'Please select a task.');
            }
        }
    }

    public function render()
    {
        return view('livewire.daily-task.show', [
            'todoTasksForTable' => $this->todoTasksForTable, // Pass To-Do tasks to the view
            'completedTasksForTable' => $this->completedTasksForTable, // Pass Completed tasks to the view
            'unassignedTasks' => $this->unassignedTasks,
            'assignedTasks' => $this->assignedTasks,
            'taskLogs' => $this->taskLogs,
        ]);
    }
}
