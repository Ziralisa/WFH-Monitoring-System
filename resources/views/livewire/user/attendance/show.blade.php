<div class="container-fluid py-4">
    <div class="page-header min-height-250 border-radius-xl mt-4"
        style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
        <h3 class="text-white font-weight-bolder mx-6 mb-4 pt-2">Hello, {{ auth()->user()->name }}!</h3>
    </div>

    <div class="card card-body blur shadow-blur mx-4 mt-6">
        <!-- CLOCK BUTTONS -->
        <div class="m-3 row">
            <div class="d-flex justify-content-center align-items-center col p-3">
                <button id="clockInBtn" class="btn btn-success btn-lg w-100 active mb-0 text-white" style="height: 125%" wire:click="clockIn" role="button"
                    aria-pressed="true" wire:confirm="Clock-in now?" {{ $isClockInDisabled ? 'disabled' : '' }}>
                    Clock-in
                </button>
                @script
                    <script>
                        //CHECKS FOR ACTIVE ATTENDANCE SESSION
                        window.onload = function() {
                            console.log("Page loaded!");

                            $wire.call('checkClockStatus').then((response) => {
                                if (response) {
                                    const { locationType, homeLat, homeLng } = response;

                                    if (locationType === "active") {
                                        // Recheck the location when the session was active
                                        if (navigator.geolocation) {
                                            navigator.geolocation.getCurrentPosition((position) => {
                                                const userPosition = {
                                                    lat: position.coords.latitude,
                                                    lng: position.coords.longitude,
                                                }
                                                console.log("Retrieved coords!");
                                                $wire.call('checkLocation', userPosition.lat, userPosition.lng).then(
                                                    (locationStatus) => {
                                                        if (!locationStatus) {
                                                            alert("You are out of range! Clocking out will not be allowed.");
                                                        }
                                                    }
                                                );
                                            });
                                        } else {
                                            console.log("Geolocation not supported");
                                        }
                                    }
                                }
                            }).catch((error) => {
                                console.error("Error calling checkClockStatus:", error);
                            });
                        };

                        //CLOCK IN BUTTON LISTENER
                        window.addEventListener('check-location-clockin', () => {
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition((position) => {
                                    const userPosition = {
                                        lat: position.coords.latitude,
                                        lng: position.coords.longitude,
                                    }
                                    console.log("Retrieved coords!");
                                    $wire.call('checkLocation', userPosition.lat, userPosition.lng).then(
                                        (locationStatus) => {
                                            if (locationStatus) {
                                                alert("User is in range.. registering clock-in");
                                                $wire.set('isClockInDisabled', true);
                                                $wire.set('isClockOutDisabled', false);
                                                $wire.set('attendanceSession', 'active');
                                                $wire.dispatch('start-attendance-session', {
                                                    locationType: 'in',
                                                    rangeStatus: 'in range'
                                                });
                                            } else {
                                                alert("Out of range! Go in range first to take clock-in/out!");
                                            }
                                        });
                                });
                            } else {
                                console.log("Geolocation not supported");
                            }
                        });

                        //CLOCK OUT BUTTON LISTENER
                        window.addEventListener('check-location-clockout', () => {
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition((position) => {
                                    const userPosition = {
                                        lat: position.coords.latitude,
                                        lng: position.coords.longitude,
                                    }
                                    console.log("Retrieved coords!");
                                    $wire.call('checkLocation', userPosition.lat, userPosition.lng).then(
                                        (locationStatus) => {
                                            if (locationStatus) {
                                                alert("User is in range.. registering clock-out");
                                                $wire.set('isClockOutDisabled', true);
                                                $wire.set('attendanceSession', 'ended');
                                                $wire.dispatch('stop-attendance-session');
                                            } else {
                                                alert("Out of range! Go in range first to take clock-in/out!");
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
                <button id="clockOutBtn" class="btn btn-primary btn-lg w-100 active mb-0 text-white" style="height: 125%" wire:click="clockOut" role="button"
                    aria-pressed="true" wire:confirm="End your attendance session?"
                    {{ $isClockOutDisabled ? 'disabled' : '' }}>
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
                    Click CLOCK IN to start record your attendance
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
    </div>
</div>
