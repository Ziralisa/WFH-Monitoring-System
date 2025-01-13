<x-layouts.base>
    @includeIf('layouts.navbars.auth.sidebar') <!-- Sidebar -->
    @includeIf('layouts.navbars.auth.nav') <!-- Navbar -->

<div class="container">
    <h1>Projects</h1>

    <!-- Create Project Form -->
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Project Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea name="description"></textarea>
        </div>
        <button type="submit">Create Project</button>
    </form>

    <hr>

    <!-- List Projects and Tasks -->
    @foreach ($projects as $project)
        <h2>{{ $project->name }}</h2>
        <p>{{ $project->description }}</p>

        <!-- Create Task Form -->
        <form action="{{ route('projects.tasks.store', $project->id) }}" method="POST">
            @csrf
            <div>
                <label for="name">Task Name:</label>
                <input type="text" name="name" required>
            </div>
            <div>
                <label for="task_status">Status:</label>
                <select name="task_status">
                    <option value="To Do">To Do</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Done">Done</option>
                    <option value="Stuck">Stuck</option>
                </select>
            </div>
            <div>
                <label for="task_priority">Priority:</label>
                <select name="task_priority">
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>
            <div>
                <label for="task_assign">Assign To:</label>
                <input type="text" name="task_assign">
            </div>
            <div>
                <label for="task_description">Description:</label>
                <textarea name="task_description"></textarea>
            </div>
            <button type="submit">Create Task</button>
        </form>

        <h3>Tasks</h3>
        <ul>
            @foreach ($project->tasks as $task)
                <li>
                    {{ $task->name }} - {{ $task->task_status }} ({{ $task->task_priority }})
                </li>
            @endforeach
        </ul>
        <hr>
    @endforeach
</div>

</x-layouts.base>