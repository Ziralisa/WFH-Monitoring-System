<x-layouts.base>
    @includeIf('layouts.navbars.auth.sidebar') <!-- Sidebar -->
    @includeIf('layouts.navbars.auth.nav') <!-- Navbar -->

    <main class="main-content mt-1 border-radius-lg">
        <div class="container mt-4">
            <h1 class="mb-4">Backlog</h1>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add Sprint Form -->
            <form action="{{ route('create-sprint') }}" method="POST">
                @csrf
                <div class="d-flex align-items-center mb-3">
                    <label for="name" class="mr-2">Sprint</label>
                    <input type="text" name="name" id="name" class="mr-2" required>

                    <label for="desc" class="mr-2">Description</label>
                    <textarea name="desc" id="desc" class="mr-2" required></textarea>

                    <label for="startdate" class="mr-2">Start Date</label>
                    <input type="date" name="startdate" id="startdate" class="mr-2" required>

                    <label for="enddate" class="mr-2">End Date</label>
                    <input type="date" name="enddate" id="enddate" class="mr-2" required>

                    <button type="submit" class="btn btn-primary">Add Sprint</button>
                </div>
            </form>

            <h2>Sprints</h2>

            <!-- Display sprint details -->
            @forelse($sprints as $sprint)
                <div>
                    <strong>Name:</strong> {{ $sprint->name }} <strong>Description:</strong> {{ $sprint->desc }} <strong>Start Date:</strong> {{ $sprint->startdate }} <strong>End Date:</strong> {{ $sprint->enddate }}
                </div>

                <!-- Display task table -->
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Priority</th>
                    </tr>
                </thead>
                
            </table>
            @empty
            <div>No sprints added yet.</div>

            @endforelse

            
        </div>
    </main>

    <style>
        label {
            font-size: 16px;
            font-weight: bold;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mr-2 {
            margin-right: 8px;
        }

        .mr-4 {
            margin-right: 16px;
        }

        .btn {
            margin-left: 10px;
        }

        /*description text*/
        textarea {
            width: 150px; 
            height: 100x; 
            resize: none;
        }
    </style>
</x-layouts.base>
