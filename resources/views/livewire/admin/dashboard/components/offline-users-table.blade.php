<h6 class="mx-4">Offline Staff</h6>
<div class="table-responsive overflow-visible">
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Name
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-0"
                    style="width: 15%;">
                    Online Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-0"
                    style="width: 15%;">
                    Last Online</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-0"
                    style="width: 15%;">
                    Clock In</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-0"
                    style="width: 15%;">
                    Contact</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 p-0"
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
                            <a href="#" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Contact link is not set!" data-container="body" data-animation="true"
                                style="opacity: 0.6; cursor: not-allowed;">
                                <i class="fa-solid fa-comments"></i>
                            </a>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group dropup">
                            <button type="button" class="btn btn-warning btn-sm dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownMenuButton">
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
