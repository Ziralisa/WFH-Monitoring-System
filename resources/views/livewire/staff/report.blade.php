<x-layouts.base>
    @include('layouts.navbars.auth.sidebar') <!-- Sidebar component inclusion -->
    <main class="main-content mt-1 border-radius-lg"> <!-- Main Content -->
        @include('layouts.navbars.auth.nav')  <!-- Navbar -->
        
        <div class="container mt-5">
            <h1 class="my-4">Attendance History</h1>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <h5 class="mb-0">Attendance Records</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Clock In Time</th>
                                        <th scope="col">Clock Out Time</th>
                                        <th scope="col">Clock In Points</th>
                                        <th scope="col">Working Hour Points</th>
                                        <th scope="col">Total Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userLocations as $location)
                                        <tr>
                                            <td class="text-center">{{ $location->created_at->format('Y-m-d') }}</td>
                                            <td class="text-center">{{ $location->created_at->format('g:i A') ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $location->type === 'clock_out' ? $location->updated_at->format('g:i A') : 'N/A' }}</td>
                                            <td class="text-center">{{ $location->clockinpoints ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $location->workinghourpoints ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $location->total_points ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $userLocations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.base>
