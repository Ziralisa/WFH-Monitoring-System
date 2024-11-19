<form method="GET" action="{{ route('admin.user-settings') }}" class="mb-3">
    <div class="form-group d-flex align-items-center">
        <label for="filter" class="me-0 mb-0">Filter User:</label>
        <select name="filter" id="filter" class="form-select form-select-sm" style="width: 200px;"
            onchange="this.form.submit()">
            <option value="">All Users</option>
            <option value="admin" {{ request('filter') == 'admin' ? 'selected' : '' }}>
                Admin</option>
            <option value="staff" {{ request('filter') == 'staff' ? 'selected' : '' }}>
                Staff</option>
            <option value="resigned" {{ request('filter') == 'resigned' ? 'selected' : '' }}>
                Resigned Staff</option>
            <option value="user" {{ request('filter') == 'user' ? 'selected' : '' }}>
                Unapproved</option>
        </select>
    </div>
</form>
