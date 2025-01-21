<?php

namespace App\Http\Livewire;

use App\Models\Task;
use App\Models\TaskLog;
use Carbon\Carbon;
use Livewire\Component;

class DailyTask extends Component
{
    public $todoTasksForTable = [];
    public $completedTasksForTable = [];
    public $unassignedTasks = [];
    public $assignedTasks = [];
    public $selectedTaskId = null; // Or set to a valid task ID if you have a default task.

    protected $taskLogs = [];
    public $startOfWeek, $endOfWeek;
    public $selectedWeek = 0; // Default to the current week
    public $availableWeeks = [];
    
    public function mount()
    {
        // Load tasks when the component is mounted
        $this->generateAvailableWeeks();
        $this->loadTasksForSelectedWeek();
        $this->loadUnassignedAndAssignedTasks();
        $this->loadTaskLogs();
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

            // // Get the start and end of the current week
            // $this->startOfWeek = Carbon::now()->startOfWeek()->toDateString();
            // $this->endOfWeek = Carbon::now()->endOfWeek()->toDateString();

            // Fetch tasks for the current week
            $todoTasks = Task::whereBetween('todo_date', [$this->startOfWeek, $this->endOfWeek])->get();
            $completedTasks = Task::whereBetween('completed_date', [$this->startOfWeek, $this->endOfWeek])->get();

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
        $taskLogs = TaskLog::with(['task.assignedUser']) // Load related task and its assigned user
            ->where('created_at', '>=', now()->subWeek()) // Logs from the past week
            ->whereIn('status', ['In Progress', 'Done', 'Stuck']) // Filter by status
            ->orderBy('created_at', 'desc') // Order by creation date
            ->get()
            ->groupBy(function ($log) {
                return $log->created_at->format('Y-m-d'); // Group by date
            });

        $this->taskLogs = $taskLogs;
    }

    public function addTodoTaskToday()
    {
        try {
            if ($this->selectedTaskId) {
                $task = Task::find($this->selectedTaskId);

                if ($task) {
                    $task->todo_date = now();
                    $task->task_status = 'In Progress';
                    $task->save();

                    TaskLog::create([
                        'task_id' => $task->id,
                        'status' => 'In Progress',
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

    public function addCompletedTaskToday()
    {
        try {
            if ($this->selectedTaskId) {
                $task = Task::find($this->selectedTaskId);

                if ($task) {
                    $task->completed_date = now();
                    $task->task_status = 'Done';
                    $task->save();

                    TaskLog::create([
                        'task_id' => $task->id,
                        'status' => 'Done',
                    ]);

                    return redirect()->route('daily.show')->with('success', 'Added task completed for today successfully.');
                } else {
                    session()->flash('error', 'Task not found.');
                }
            } else {
                session()->flash('error', 'Please select a task.');
            }
        } catch (\Exception $e) {
            \Log::error('Error adding completed task: ' . $e->getMessage(), [
                'task_id' => $this->selectedTaskId,
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'An unexpected error occurred while adding the task.');
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
            'startOfWeek' => $this->startOfWeek,
            'endOfWeek' => $this->endOfWeek,
        ]);
    }
}
