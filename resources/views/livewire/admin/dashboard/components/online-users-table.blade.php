<div class="mt-3 row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Online Staff</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Clock In</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Clock Out</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Online Status</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Location Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($usersOnPage && count($usersOnPage) > 0)
                                @foreach ($usersOnPage as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    {{-- Random profile picture --}}
                                                    <img src="../assets/img/team-{{ rand(1, 6) }}.jpg"
                                                        class="avatar avatar-sm me-3">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $user['name'] }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $user['email'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{-- Display Latest Location created today --}}
                                            @if (!empty($user['locations']))
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ \Carbon\Carbon::parse($user['locations'][0]['created_at'])->format('h:i A') }}
                                                </p>
                                            @else
                                                <p class="text-xs text-secondary mb-0">N/A</p>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            {{-- Display updated_at time if status is 'clock_out', else N/A --}}
                                            @if (!empty($user['locations']) && $user['locations'][0]['type'] === 'clock_out')
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ \Carbon\Carbon::parse($user['locations'][0]['updated_at'])->format('h:i A') }}
                                                </p>
                                            @else
                                                <p class="text-xs font-weight-bold mb-0 ">N/A</p>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge bg-success">Online</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            {{-- Display location range status --}}
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
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No user found</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="text-center" colspan="100%">
                                    <a href="#" wire:click="viewOfflineUsers"
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder">View
                                        More</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @if ($showOfflineUser)
                    <hr>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <h6 class="mx-4">Offline Staff</h6>
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>

                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Clock In</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Clock Out</th>

                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Online Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($offlineUsers as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        {{-- Random profile picture --}}
                                                        <img src="../assets/img/team-{{ rand(1, 6) }}.jpg"
                                                            class="avatar avatar-sm me-3">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $user['name'] }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $user['email'] }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-sm">
                                                <p class="text-xs font-weight-bold mb-0 ">N/A</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0 ">N/A</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="badge bg-danger">Offline</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="btn-group dropup">
                                                    <button type="button"
                                                        class="btn btn-warning btn-sm dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Dropup
                                                    </button>
                                                    <ul class="dropdown-menu px-2 py-3"
                                                        aria-labelledby="dropdownMenuButton">
                                                        <li>
                                                            <a class="dropdown-item border-radius-md"
                                                               href="{{ route('view-user-profile', $user['id']) }}">
                                                                View Profile
                                                            </a>
                                                        </li>
                                                        <li><a class="dropdown-item border-radius-md"
                                                                href="javascript:;">View Attendance Location Log</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
