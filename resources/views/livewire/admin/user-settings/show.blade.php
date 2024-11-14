<div>
    <h1 class="m-4">Users</h1>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <!-- Filter form component-->
                    @include('livewire.admin.user-settings.components.filter-form')
                </div>

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

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No.</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Role</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        style="width: 150px;">Actions</th>
                                    <!-- Set a fixed width for Actions column -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-xs text-center font-weight-bold mb-0">{{ $loop->iteration }}
                                        </td>
                                        <td class="text-xs text-center font-weight-bold mb-0">{{ $user->name }}
                                        </td>
                                        <td class="text-xs text-center font-weight-bold mb-0">{{ $user->email }}
                                        </td>
                                        <td class="text-xs text-center font-weight-bold mb-0">
                                            {{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                                        <td class="text-xs text-center font-weight-bold mb-0">

                                            <button type="button" class="btn btn-warning edit-button btn-sm"
                                                data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}" data-phone="{{ $user->phone }}"
                                                data-location="{{ $user->location }}" data-toggle="modal"
                                                data-target="#editUserModal">
                                                Edit Info
                                            </button>
                                            <form action="{{ route('admin.user.delete', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Confirmation Modal -->
                @include('livewire.admin.user-settings.components.confirm-modal')

                <!-- Edit User Modal -->
                @include('livewire.admin.user-settings.components.edit-modal')
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
            const userId = $(this).data('id');
            const userName = $(this).data('name');
            const userEmail = $(this).data('email');
            const userRole = $(this).data('role');


            $('#editUserModal #edit-name').val(userName);
            $('#editUserModal #edit-email').val(userEmail);
            $('#editUserModal #edit-role').val(userRole);

            $('#editUserForm').attr('action', '/admin/user/' + userId);
        });
    </script>
</div>
