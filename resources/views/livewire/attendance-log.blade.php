<main class="main-content">
    <div class="container-fluid py-4">
        <h1 class="mb-4">Attendance Log</h1>
        <div class="card card-body blur shadow-blur mx-4 mt-6">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="../assets/img/team-5.jpg" alt="..." class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <a class="mb-1 .h5 font-weight-bold text-lg" href="{{ route('view-user-profile', $user->id) }}">
                            {{ $user->first_name . ' ' . $user->last_name }}
                        </a>
                        {{-- <h5 class="mb-1">
                            {{ $user->first_name . ' ' . $user->last_name }}
                        </h5> --}}
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ $user->position ?? 'Employee' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3 row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h6>Log History</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        User ID</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Location</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Latitude</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Longitude</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($locations as $location)
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $location['date'] }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $location['time'] }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $location['user_id'] }}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0">{{ $location['name'] }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0">
                                                {{ $location['location'] }}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0">
                                                {{ $location['latitude'] }}</p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0">
                                                {{ $location['longitude'] }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
