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
                        <form method="POST" action="{{ route('attendance.clock-in') }}" id="clockInForm">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 mb-2" id="clockInButton">Clock In</button>
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
                        <h6>Attendance Report</h6>
                    </div>
                    <div class="card-body">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Work Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example Rows -->
                                <tr>
                                    <td class="text-xs">2024-10-10</td>
                                    <td class="text-xs">Clocked In</td>
                                    <td class="text-xs text-center">8 Hours</td>
                                </tr>
                                <tr>
                                    <td class="text-xs">2024-10-09</td>
                                    <td class="text-xs">Clocked Out</td>
                                    <td class="text-xs text-center">7.5 Hours</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
    document.getElementById('clockInForm').addEventListener('submit', function() {
        var clockInButton = document.getElementById('clockInButton');
        clockInButton.disabled = true; // Disable the button
        clockInButton.innerText = 'Clocking In...'; // Optional: Change button text
    });
</script>
