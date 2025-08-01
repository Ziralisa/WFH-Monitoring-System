<?php

namespace App\Http\Livewire;

use App\Models\Task;
use App\Models\TaskLog;
use Carbon\Carbon;
use Livewire\Component;

class DailyTask extends Component
{
    public $todoTasksForTable = [];
    //TAMBAH
    public $inprogressTasksForTable = [];
    //
    public $completedTasksForTable = [];
    public $customTasksForTable = [];
    public $unassignedTasks = [];
    public $assignedTasks = [];
    public $selectedTaskId = null;
    public $customTaskTitle = '';
    public $customTasks;
    protected $taskLogs = [];
    public $startOfWeek, $endOfWeek;
    public $selectedWeek = 0;
    public $availableWeeks = [];

    public function mount()
    {
        $this->generateAvailableWeeks();
        $this->loadTasksForSelectedWeek();
        $this->loadUnassignedAndAssignedTasks();
        $this->loadTaskLogs();
        $this->customTasks = TaskLog::where('status', 'In Progress')
            ->whereNotNull('title')
            ->where('user_id', auth()->id())
            ->get();

    }

    public function generateAvailableWeeks()
    {
        $this->availableWeeks = [];
        $currentWeek = now()->startOfWeek(); // Get the current week's start date

        // Loop for the current week and the previous 3 weeks
        for ($i = 0; $i >= -3; $i--) {
            $startOfWeek = $currentWeek->copy()->addWeeks($i);
            $endOfWeek = $startOfWeek->copy()->endOfWeek();
            $weekNumber = $startOfWeek->weekOfYear;
            $year = $startOfWeek->year;

            $this->availableWeeks[] = [
                'start' => $startOfWeek->format('d/m/Y'), // Format: 6/01/2025
                'end' => $endOfWeek->format('d/m/Y'), // Format: 10/01/2025
                'weekNumber' => $weekNumber, // Week number (e.g., 1, 2, 3)
                'year' => $year, // Year (e.g., 2025)
            ];
        }

        // Default selectedWeek is set to the current week (latest week in the array)
        $this->selectedWeek = 0;
    }

    public function loadTasksForSelectedWeek()
    {
        if ($this->selectedWeek == 0) {

        }
        $selectedWeekData = $this->availableWeeks[$this->selectedWeek];

        $this->startOfWeek = Carbon::createFromFormat('d/m/Y', $selectedWeekData['start']);
        $this->endOfWeek = Carbon::createFromFormat('d/m/Y', $selectedWeekData['end']);

        //TAMBAH
        // Fetch tasks for the current week
        $todoTasks = Task::where('task_assign', auth()->id())
            ->whereBetween('todo_date', [$this->startOfWeek, $this->endOfWeek])
            ->get();

        $inprogressTasks = Task::where('task_assign', auth()->id())
            ->whereBetween('inprogress_date', [$this->startOfWeek, $this->endOfWeek])
            ->get();

        $completedTasks = Task::where('task_assign', auth()->id())
            ->whereBetween('completed_date', [$this->startOfWeek, $this->endOfWeek])
            ->get();
        //

        $customTasks = TaskLog::where('user_id', auth()->id())
            ->whereBetween('created_at', [$this->startOfWeek, $this->endOfWeek])
            ->get();
        // Group tasks by day name for both To-Do and Completed
        $todoTasksByDay = $todoTasks->groupBy(function ($task) {
            return Carbon::parse($task->todo_date)->format('l');
        });

        //TAMBAH
        $inprogressTasksByDay = $inprogressTasks->groupBy(function ($task) {
            return Carbon::parse($task->inprogress_date)->format('l');
        });
        //

        $completedTasksByDay = $completedTasks->groupBy(function ($task) {
            return Carbon::parse($task->completed_date)->format('l');
        });

        $customTasksByDay = $customTasks->groupBy(function ($taskLogs) {
            return Carbon::parse($taskLogs->created_at)->format('l');
        });

        // Prepare tasks for each weekday column
        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $this->todoTasksForTable = [];
        foreach ($weekDays as $day) {
            $this->todoTasksForTable[$day] = $todoTasksByDay[$day] ?? collect();
        }

        //TAMBAH
        $this->inprogressTasksForTable = [];
        foreach ($weekDays as $day) {
            $this->inprogressTasksForTable[$day] = $inprogressTasksByDay[$day] ?? collect();
        }
        //

        $this->completedTasksForTable = [];
        foreach ($weekDays as $day) {
            $this->completedTasksForTable[$day] = $completedTasksByDay[$day] ?? collect();
        }

        $this->customTasksForTable = [];
        foreach ($weekDays as $day) {
            $this->customTasksForTable[$day] = $customTasksByDay[$day] ?? collect();
        }

    }

    //TAMBAH
    public function loadUnassignedAndAssignedTasks()
    {
        $this->unassignedTasks = Task::where('task_assign', auth()->id())
            ->whereNull('todo_date')
            ->get();

        $this->assignedTasks = Task::where('task_assign', auth()->id())
            ->whereNull('completed_date')
            ->where(function($query) {
                $query->whereNotNull('todo_date')
                      ->orWhereNotNull('inprogress_date');
        })
        ->get();
    }

    public function loadTaskLogs()
    {
        $taskLogs = TaskLog::with(['task.assignedUser'])
            ->where('user_id', auth()->id())
            ->where('created_at', '>=', now()->subWeek())
            ->whereIn('status', ['In Progress', 'Done', 'Stuck'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($log) {
                return $log->created_at->format('Y-m-d');
            });

        $this->taskLogs = $taskLogs;
    }

    public function addTodoTaskToday()
    {
        try {
            if ($this->selectedTaskId) {
                $task = Task::find($this->selectedTaskId);

                if ($task && $task->task_assign == auth()->id()) {
                    $task->todo_date = now();
                    $task->task_status = 'In Progress';
                    $task->save();

                    TaskLog::create([
                        'task_id' => $task->id,
                        'status' => 'In Progress',
                        'user_id' => auth()->id(),
                    ]);

                    return redirect()->route('daily.show')->with('success', 'Added task to-do task for today successfully.');
                } else {
                    session()->flash('error', 'Task not found.');
                }
            } else {
                session()->flash('error', 'Please select a task.');
            }
        } catch (\Exception $e) {
            \Log::error('Error adding task to-do: ' . $e->getMessage(), [
                'task_id' => $this->selectedTaskId,
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'An unexpected error occurred while adding the task.');
        }
    }

    //TAMBAH
    public function addInprogressTaskToday()
    {
        try {
            if ($this->selectedTaskId) {
                $task = Task::find($this->selectedTaskId);

                if ($task && $task->task_assign == auth()->id()) {
                    $task->inprogress_date = now();
                    //TAMBAH
                    $task->completed_date = null; // Clear completed
                    $task->todo_date = null;        // Clear to do
                    //
                    $task->task_status = 'In Progress';
                    $task->save();

                    TaskLog::create([
                        'task_id' => $task->id,
                        'status' => 'In Progress',
                        'user_id' => auth()->id(),
                    ]);

                    return redirect()->route('daily.show')->with('success', 'Added task in progress for today successfully.');
                } else {
                    session()->flash('error', 'Task not found.');
                }
            } else {
                session()->flash('error', 'Please select a task.');
            }
        } catch (\Exception $e) {
            \Log::error('Error adding task in progress: ' . $e->getMessage(), [
                'task_id' => $this->selectedTaskId,
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'An unexpected error occurred while adding the task.');
        }
    }

    public function addCustomTaskToday()
    {
        try {
            if ($this->customTaskTitle) {
                TaskLog::create([
                    'title' => $this->customTaskTitle,
                    'status' => 'In Progress',
                    'user_id' => auth()->id(),
                ]);

                $this->customTaskTitle = '';
                return redirect()->route('daily.show')->with('success', 'Custom task added successfully.');
            } else {
                session()->flash('error', 'Please provide a title for the custom task.');
            }
        } catch (\Exception $e) {
            \Log::error('Error adding custom task: ' . $e->getMessage(), [
                'custom_task_title' => $this->customTaskTitle,
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'An unexpected error occurred while adding the custom task.');
        }
    }

    public function addCompletedTaskToday()
    {
        try {
            if ($this->selectedTaskId) {
                // Check if selected task is from assigned tasks or a custom task
                $task = Task::find($this->selectedTaskId) ?? TaskLog::find($this->selectedTaskId);
    
                if ($task) {
                    if ($task instanceof Task) {
                        
                        // Update the task in the tasks table
                        $task->completed_date = now();
                        //TAMBAH
                        $task->inprogress_date = null; // Clear in progress
                        $task->todo_date = null;        // Clear to do
                        //
                        $task->task_status = 'Done';
                        $task->save();
    
                        // Find the latest task log for this task and update its status
                        $taskLog = TaskLog::where('task_id', $task->id)
                            ->where('user_id', auth()->id())
                            ->latest() // Get the most recent log entry
                            ->first();
    
                        if ($taskLog) {
                            $taskLog->status = 'Done';
                            $taskLog->save();
                        }
                    } elseif ($task instanceof TaskLog) {
                        // For custom tasks (TaskLog), update the status directly
                        $task->status = 'Done';
                        $task->save();
                    }
    
                    return redirect()->route('daily.show')->with('success', 'Task marked as completed for today successfully.');
                } else {
                    session()->flash('error', 'Task not found.');
                }
            } else {
                session()->flash('error', 'Please select a task.');
            }
        } catch (\Exception $e) {
            \Log::error('Error adding completed task: ' . $e->getMessage(), [
                'task_id' => $this->selectedTaskId,
                'custom_task_title' => $this->customTaskTitle,
                'trace' => $e->getTraceAsString(),
            ]);
    
            session()->flash('error', 'An unexpected error occurred while adding the task.');
        }
    }

    public function render()
    {
        return view('livewire.daily-task.show', [
            'todoTasksForTable' => $this->todoTasksForTable,
            'inprogressTasksForTable' => $this->inprogressTasksForTable,
            'completedTasksForTable' => $this->completedTasksForTable,
            'unassignedTasks' => $this->unassignedTasks,
            'assignedTasks' => $this->assignedTasks,
            'taskLogs' => $this->taskLogs,
            'startOfWeek' => $this->startOfWeek,
            'endOfWeek' => $this->endOfWeek,
        ]);
    }
}