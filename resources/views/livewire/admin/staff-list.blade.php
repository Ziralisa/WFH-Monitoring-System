<x-layouts.base>
    @include('layouts.navbars.auth.sidebar') <!-- Sidebar component inclusion -->

    <main class="main-content mt-1 border-radius-lg"> <!-- Main Content -->
        @include('layouts.navbars.auth.nav')  <!-- Navbar -->

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
                @endif

                <button type="button" class="btn btn-warning edit-button btn-sm" data-id="{{ $member->id }}" data-name="{{ $member->name }}" data-email="{{ $member->email }}" data-phone="{{ $member->phone }}" data-location="{{ $member->location }}" data-toggle="modal" data-target="#editStaffModal">
                    Edit Info
                </button>

                <!-- Show Delete button if the user does not have the 'staff' role -->
                @if (!$member->hasRole('staff'))
                <form action="{{ route('admin.staff.delete', $member->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this staff member?')">
        Delete
    </button>
</form>

@endif

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

        <!-- Edit Staff Modal -->
        <div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStaffModalLabel">Edit Staff Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editStaffForm" method="POST" action="">
                            @csrf
                            @method('PUT') 

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="edit-name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="edit-email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="edit-phone" name="phone" required>
                            </div>

                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" class="form-control" id="edit-location" name="location" required>
                            </div>

                            <button type="submit" class="btn btn-success btn-block">Update Staff</button>
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

            $('.edit-button').on('click', function() {
                const staffId = $(this).data('id');
                const staffName = $(this).data('name');
                const staffEmail = $(this).data('email');
                const staffPhone = $(this).data('phone');
                const staffLocation = $(this).data('location');

                $('#editStaffModal #edit-name').val(staffName);
                $('#editStaffModal #edit-email').val(staffEmail);
                $('#editStaffModal #edit-phone').val(staffPhone);
                $('#editStaffModal #edit-location').val(staffLocation);

                $('#editStaffForm').attr('action', '/admin/staff/' + staffId);

            });
        </script>
                @include('layouts.footers.auth.footer')
    </main>
</x-layouts.base>
