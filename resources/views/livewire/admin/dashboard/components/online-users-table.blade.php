<style>
    .btnaction {
        background-color: #0070ff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 12px;
    }

    .btnaction:hover{
        background-color: #0070ff;
        color: white;
    }

    table th,
    table td {
        border: none !important;
    }
    
    .head {
        background-color: #0070ff;
        color: rgb(255, 255, 255);
    }

    tbody tr {
        background-color: #f8f8f8;
        color: black;
    }

    tbody th {
        color: white;
    }

    table thead th:first-child {
        border-top-left-radius: 8px;
    }

    table thead th:last-child {
        border-top-right-radius: 8px;
    }

    table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 8px;
    }

    table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 8px;
    }
    table tbody tr:hover {
        background-color: #d4e2ff;
        cursor: pointer;
        color: #000000;
    }
    
    .outer-border {
    border: 1px solid rgb(255, 255, 255);
    border-radius: 8px;
    border-collapse: separate;
    border-spacing: 0;
    overflow: hidden;
    width: 100%;
    max-width: 1000px;
    margin: 0 auto 30px auto;
    }

</style>

<div class="mt-3 row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Online Staff</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="usertable table-responsive mt-3-mb-5">
                    <table class="table align-items-center mb-0 modern-table outer-border">
                        <thead>
                            <tr class="head text-center">
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-white">Name
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder text-white p-0"
                                    style="width: 15%;">
                                    Online Status
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder text-white p-0"
                                    style="width: 15%;">
                                    Location Status
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder text-white p-0"
                                    style="width: 15%;">
                                    Clock In
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder text-white p-0"
                                    style="width: 15%;">
                                    Contact
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder text-white p-0"
                                    style="width: 15%;">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($usersOnPage && count($usersOnPage) > 0)
                                @foreach ($usersOnPage as $user)
                                    <tr>
                                        <td style="width: 350px;">
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../assets/img/team-{{ rand(1, 6) }}.jpg"
                                                        class="avatar avatar-sm me-3">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <a class="mb-0 text-sm font-weight-bold"
                                                        href="
                                                        @if ($user['id'] === auth()->user()->id) {{ route('user-profile') }}
                                                        @else
                                                            {{ route('view-user-profile', $user['id']) }} @endif">
                                                        {{ $user['name'] }}
                                                    </a>
                                                    <a class="text-xs text-secondary mb-0" href="{{ route('view-user-profile', $user['id']) }}">{{ $user['email'] }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success">Online</span>
                                        </td>
                                        <td class="text-center text-sm">
                                            @if (
                                                !empty($user['locations']) &&
                                                    $user['locations'][0]['status'] === 'active' &&
                                                    $user['locations'][0]['in_range'] === 1)
                                                <span class="badge bg-success">In Range</span>
                                            @elseif (
                                                !empty($user['locations']) &&
                                                    $user['locations'][0]['status'] === 'active' &&
                                                    $user['locations'][0]['in_range'] === 0)
                                                <span class="badge bg-warning text-dark">Out of Range</span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td class="text-center text-sm">
                                            @if (!empty($user['locations']))
                                                @if ($user['locations'][0]['type'] === 'clock_in')
                                                    <p class="text-xs text-secondary mb-0">
                                                        Clocked in at:<br>
                                                        <strong>
                                                            {{ \Carbon\Carbon::parse($user['locations'][0]['created_at'])->format('h:i A') }}
                                                        </strong>
                                                    </p>
                                                @else
                                                    <p class="text-xs text-secondary mb-0">
                                                        Clocked out at:
                                                        {{ \Carbon\Carbon::parse($user['locations'][0]['updated_at'])->format('h:i A') }}
                                                    </p>
                                                @endif
                                            @else
                                                <p class="text-xs text-secondary mb-0">N/A</p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (!empty($user['contact_link']))
                                                <a href="{{ $user['contact_link'] }}" target="_blank"
                                                    rel="noopener noreferrer">
                                                    <i class="fa-solid fa-comments"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" class="btn-tooltip" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Contact link is not set!"
                                                    data-container="body" data-animation="true"
                                                    style="pointer-events: none; opacity: 0.6; cursor: not-allowed;">
                                                    <i class="fa-solid fa-comments"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group dropdown">
                                                <button type="button" class="btn btnaction btn-sm dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu px-2 py-3"
                                                    aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a class="dropdown-item border-radius-md"
                                                            href="@if ($user['id'] === auth()->user()->id) {{ route('user-profile') }}
                                                            @else
                                                                {{ route('view-user-profile', $user['id']) }} @endif
                                                            ">View
                                                            Profile</a>
                                                    </li>
                                                    <li>
                                                        {{-- <a class="dropdown-item border-radius-md"
                                                            href="{{ route('attendance-log', $user['id']) }}">View
                                                            Attendance Location Log</a> --}}
                                                        <a class="dropdown-item border-radius-md"
                                                            href="javascript:void(0)"
                                                            wire:click="showAttendanceLog({{ $user['id'] }})"
                                                            data-bs-toggle="modal" data-bs-target="#logModal">View
                                                            Attendance Location Log</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item border-radius-md"
                                                            href="javascript:void(0)"
                                                            wire:click='editContactLink({{ $user['id'] }})'
                                                            data-bs-toggle="modal" data-bs-target="#contactModal">
                                                            Edit Contact Link</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No user found</td>
                                </tr>
                            @endif
                            @if (!$showOfflineUser)
                                <tr>
                                    <td class="text-center" colspan="100%">
                                        <a href="#" wire:click="viewOfflineUsers" class="font-weight-bolder">View
                                            More</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if ($showOfflineUser)
                    <hr>
                    @include('livewire.admin.dashboard.components.offline-users-table')
                @endif
            </div>
            @include('livewire.admin.dashboard.components.edit-contact')
            @include('livewire.admin.dashboard.components.attendance-log')
        </div>
    </div>
</div>
