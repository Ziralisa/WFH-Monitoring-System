<div class="container-fluid py-4">
    <div class="page-header min-height-250 border-radius-xl mt-4"
        style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        {{-- <span class="mask bg-gradient-primary opacity-6"></span> --}}
        <h3 class="text-white font-weight-bolder mx-6 mb-4 pt-2">Hello, {{ auth()->user()->name }}!</h3>
    </div>
    @include('livewire.user-on-this-page')
    <div class="container py-4 text-center">
        <p style="font-size: 24px; font-weight: bold;">Weekly Performance: <strong>{{ $weeklyStatus }}</strong></p>
    </div>



    <div class="card card-body blur shadow-blur mx-4 mt-6">
        <!-- CLOCK BUTTONS -->
        <div class="m-3 row">
            <div class="d-flex justify-content-center align-items-center col p-3">
                <button id="clockInBtn" class="btn btn-success btn-lg w-100 active mb-0 text-white" style="height: 125%"
                    aria-pressed="true" {{ $isClockInDisabled ? 'disabled' : '' }}>
                    Clock-in
                </button>
                @script
                <script>
                    // CLOCK IN BUTTON LISTENER
                    document.getElementById('clockInBtn').addEventListener('click', () => {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition((position) => {
                                const userPosition = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };

                                $wire.call('checkLocation', userPosition.lat, userPosition.lng).then(
                                    (locationStatus) => {
                                        console.log("Location Status: ", locationStatus);
                                        if (locationStatus) {
                                            alert("User is in range.. registering clock-in");
                                            $wire.call('clockIn');
                                        } else {
                                            alert("Out of range! Go in range first to clock in!");
                                        }
                                    }
                                );
                            });
                        } else {
                            console.log("Geolocation not supported");
                        }
                    });


                    // CLOCK OUT BUTTON LISTENER
                    document.getElementById('clockOutBtn').addEventListener('click', () => {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition((position) => {
                                const userPosition = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };

                                $wire.call('checkLocation', userPosition.lat, userPosition.lng).then(
                                    (locationStatus) => {
                                        if (locationStatus) {
                                            alert("User is in range.. registering clock-out");
                                            // Only call the clockOut method when in range
                                            $wire.call('clockOut');
                                            $wire.set('isClockOutDisabled', true);
                                            $wire.set('attendanceSession', 'ended');
                                        } else {
                                            alert("Out of range! Go in range first to clock out!");
                                        }
                                    }
                                );
                            });
                        } else {
                            console.log("Geolocation not supported");
                        }
                    });
                </script>
                @endscript
            </div>
            <div class="d-flex justify-content-center align-items-center col p-3">
                <button id="clockOutBtn" class="btn btn-primary btn-lg w-100 active mb-0 text-white"
                    style="height: 125%" aria-pressed="true" {{ $isClockOutDisabled ? 'disabled' : '' }}>
                    Clock-out
                </button>
            </div>

        </div>
        <!-- CLOCK BUTTON ROW ENDS -->
        <div class="row">
            @if ($attendanceSession == 'ended')
                <h6 class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-7 pt-6">
                    Attendance Session: Ended <br>
                    Your clock-in time: {{ $clockInTime ?? 'N/A' }} <br>
                    Your clock-out time: {{ $clockOutTime ?? 'N/A' }} <br>
                    Your Clock-in point: {{ $clockInPoints ?? 'N/A' }} <br>
                    Your Working Hour Points: {{ $workingHourPoints ?? 'N/A' }} <br>
                    Your Total Points: {{ $totalPoints ?? 'N/A' }} <br>
                </h6>
            @elseif ($attendanceSession == 'active')
                <h6 class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-7 pt-6">
                    Attendance Session: Active <br>
                    Your clock-in time: {{ $clockInTime ?? 'N/A' }}
                </h6>
            @else
                <h6 class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-7 pt-6">
                    Click CLOCK IN to start recording your attendance
                </h6>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6 class="py-3">Home Location</h6>
                    </div>
                    @include('livewire.user.attendance.includes.map')
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6 class="py-3">Attendance Analytics</h6>
                    </div>
                    <div class="card-body">
                        <!-- Container for the Chart -->
                        <canvas id="attendanceChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Fetch attendance data from the backend
        fetch('/attendance-data') // This calls the API route defined above
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    // Limit to the last 30 data points
                    const limitedData = data.slice(0, 10);
                    // Process the data and render the chart
                    const labels = data.map(item => {
                        // Format the date to 'Y-m-d' format if needed
                        const date = new Date(item.created_at);
                        const formattedDate = date.toISOString().split('T')[0]; // Formats as 'YYYY-MM-DD'
                        return formattedDate;
                    });


                    const points = limitedData.map(item => item.total_points);

                    // Render the chart with the data
                    const ctx = document.getElementById('attendanceChart').getContext('2d');
                    const attendanceChart = new Chart(ctx, {
                        type: 'line', // Chart type
                        data: {
                            labels: labels, // Dates
                            datasets: [{
                                label: 'Total Points',
                                data: points, // Points
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                } else {
                    console.log("No attendance data found.");
                }
            })
            .catch(error => {
                console.error('Error fetching attendance data:', error);
                alert("An error occurred while fetching attendance data.");
            });
    });
</script>