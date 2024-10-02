<x-layouts.base>
    @include('layouts.navbars.auth.sidebar') <!-- Sidebar component inclusion -->
    
    <!-- Main Content -->
    <main class="main-content mt-1 border-radius-lg">
        <!-- Navbar -->
        @include('layouts.navbars.auth.nav') <!-- Corrected navbar component inclusion -->
        
    <div class="container mt-5">
        <h1 class="mb-4">Staff List</h1>

        <form method="GET" action="{{ route('admin.staff-list') }}" class="mb-3">
            <div class="form-group">
                <label for="filter">Filter Staff:</label>
                <select name="filter" id="filter" class="form-control" onchange="this.form.submit()">
                    <option value="">All Staff</option>
                    <option value="resigned" {{ request('filter') == 'resigned' ? 'selected' : '' }}>Resigned Staff</option>
                </select>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($staff as $member)
                    <tr class="{{ $member->hasRole('resign') ? 'resigned' : '' }}">
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ implode(', ', $member->getRoleNames()->toArray()) }}</td>
                        <td>
                            @if ($member->hasRole('staff'))
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmModal" onclick="setFormAction('{{ route('admin.staff.remove-role', $member->id) }}')">
                                    Remove Role
                                </button>
                            @else
                                <span class="text-muted">No Staff Role</span>
                            @endif
                            
                            <a href="{{ route('admin.edit-staff', $member->id) }}" class="btn btn-warning">Edit Info</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this role?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="confirmDeleteForm" method="POST" action="" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Remove Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function setFormAction(action) {
            document.getElementById('confirmDeleteForm').action = action;
        }
    </script>
    </main>
</x-layouts.base>
