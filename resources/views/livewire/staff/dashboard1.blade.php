<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">

        <!-- Include top-row components -->
        @include('livewire.dashboard.components.top-row')

        <!-- Attendance Section -->
        <div class="row mt-4">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Attendance Tracking</h6>
                    </div>
                    <div class="card-body">
                        <!-- Clock-in / Clock-out Buttons -->
                        <form method="POST" action="{{ route('attendance.clock-in') }}">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 mb-2">Clock In</button>
                        </form>

                        <form method="POST" action="{{ route('attendance.clock-out') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">Clock Out</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-1">Attendance Report</h6>
                            <div class="d-flex align-items-center">
                                <hr class="flex-grow-1" />
                                <a href="{{ route('report') }}" class="btn btn-link ms-2">See All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th class="text-center">Work Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                                                <tr>
                                                                    <td>{{ $attendance->created_at->format('Y-m-d') }}</td>
                                                                    <td>{{ $attendance->clock_out ? 'Clocked Out' : 'Clocked In' }}</td>
                                                                    @php
                                                                        // Calculate the difference in hours and minutes
                                                                        $totalMinutes = $attendance->clock_in->diffInMinutes($attendance->clock_out);
                                                                        $hours = floor($totalMinutes / 60); // Get whole hours
                                                                        $minutes = $totalMinutes % 60; // Get remaining minutes
                                                                    @endphp
                                                                    <td class="text-center">
                                                                        @if($hours > 0)
                                                                            {{ $hours }} Hours {{ $minutes }} Minutes
                                                                        @else
                                                                            {{ $minutes }} Minutes
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <!-- Dashboard Charts -->
            <div class="row mt-4">
                <div class="col-lg-12">
                    <canvas id="chart-bars"></canvas>
                    <canvas id="chart-line"></canvas>
                </div>
            </div>
        </div>
</main>

<!-- Core JS Files -->
<script src="/assets/js/plugins/chartjs.min.js"></script>
<script src="/assets/js/plugins/Chart.extension.js"></script>
<script>
    // ChartJS code remains the same as provided above
</script>