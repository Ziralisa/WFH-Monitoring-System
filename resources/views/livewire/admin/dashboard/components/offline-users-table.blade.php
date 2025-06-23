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
    overflow: visible !important;
    width: 100%;
    max-width: 1000px;
    margin: 0 auto 30px auto;
    }

.dropdown-menu {
    min-width: 120px;
    padding: 10px;
    z-index: 9999 !important;
}

.dropdown-menu-left {
    right: 100%;  /* position to the left of the button */
    left: auto;
    top: 0;
    transform: translateX(-10px); /* optional: small space */
}
</style>


<h6 class="mx-4">Offline Staff</h6>
<div class="usertable table-responsive mt-3-mb-5">
    <table class="table align-items-center mb-0 modern-table outer-border">
        <thead>
            <tr class="head text-center">
                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-white">
                    Name
                </th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder text-white p-0"
                    style="width: 15%;">
                    Online Status</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder text-white p-0"
                    style="width: 15%;">
                    Last Online</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder text-white p-0"
                    style="width: 15%;">
                    Clock In</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder text-white p-0"
                    style="width: 15%;">
                    Contact</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder text-white p-0"
                    style="width: 15%;">
                    Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($offlineUsers as $user)
                <tr>
                    <td style="width: 350px;">
                        <div class="d-flex px-2 py-1">
                            <div>
                                <img src="../assets/img/team-{{ rand(1, 6) }}.jpg" class="avatar avatar-sm me-3">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <a class="mb-0 text-sm font-weight-bold" href="{{ route('view-user-profile', $user['id']) }}">{{ $user['name'] }}</a>
                                <a class="text-xs text-secondary mb-0" href="{{ route('view-user-profile', $user['id']) }}">{{ $user['email'] }}</a>
                            </div>
                        </div>
                    </td>

                    <td class="text-center">
                        <span class="badge bg-secondary">Offline</span>
                    </td>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0 ">
                            @if ($user['last_online'] == null)
                                <p class="text-xs font-weight-bold mb-0 ">N/A</p>
                            @else
                                {{ \Carbon\Carbon::parse($user['last_online'])->diffForHumans() }}
                            @endif
                        </p>
                    </td>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0 ">N/A</p>
                    </td>
                    <td class="text-center">
                        {{-- @dump($user['contact_link']) --}}
                        @if (!empty($user['contact_link']))
                            <a href="{{ $user['contact_link'] }}" target="_blank" rel="noopener noreferrer">
                                <i class="fa-solid fa-comments"></i>
                            </a>
                        @else
                            <a href="javascript:void(0)" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Contact link is not set!" data-container="body" data-animation="true"
                                style="opacity: 0.6; cursor: not-allowed;">
                                <i class="fa-solid fa-comments"></i>
                            </a>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="dropdown position-relative d-inline-block">
                            <button type="button" class="btn btnaction btn-sm dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu dropdown-menu-left px-2 py-3" aria-labelledby="dropdownMenuButton">

                                <li>
                                    <a class="dropdown-item border-radius-md"
                                        href="{{ route('view-user-profile', $user['id']) }}">View
                                        Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="javascript:void(0)"
                                        wire:click="showAttendanceLog({{ $user['id'] }})" data-bs-toggle="modal"
                                        data-bs-target="#logModal">View
                                        Attendance Location Log</a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="javascript:void(0)"
                                        wire:click='editContactLink({{ $user['id'] }})' data-bs-toggle="modal"
                                        data-bs-target="#contactModal">
                                        Edit Contact Link</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

