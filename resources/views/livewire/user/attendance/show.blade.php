<div class="card card-body blur shadow-blur mx-4 mt-6">
    <div class="container-fluid py-4">
        <!-- CLOCK BUTTONS -->
        <div class="m-3 row">
            <div class="d-flex justify-content-center align-items-center col p-3">
                <button id="clockInBtn" class="btn btn-primary btn-lg active mb-0 text-white" wire:click="clockIn" role="button"
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
                                    const {
                                        locationType,
                                        homeLat,
                                        homeLng
                                    } = response; // Destructure only if response is not null
                                    alert(homeLat, homeLng);

                                    if (locationType === "in" || locationType === "active") {
                                        alert("Detected active attendance session, do you wish to continue the session?");
                                        $wire.dispatch('start-attendance-session', {
                                            locationType: 'active',
                                            homeLat: homeLat,
                                            homeLng: homeLng
                                        });
                                    } else if (locationType === "") {
                                        console.log("No location data found for today, proceeding normal use case...");
                                    }
                                } else {
                                    console.log("No data returned from checkClockStatus");
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
                                                alert("User is in range.. registering clock-out");
                                                $wire.set('isClockInDisabled', true);
                                                $wire.set('isClockOutDisabled', false);
                                                $wire.set('attendanceSession', 'active');
                                                $wire.dispatch('start-attendance-session', {
                                                    locationType: 'in',
                                                    rangeStatus: 'in range'
                                                });

                                            } else
                                                alert("Out of range! Go in range first to take clock-in/out!");
                                        })
                                })
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
                                            } else
                                                alert("Out of range! Go in range first to take clock-in/out!");
                                        })
                                })
                            } else {
                                console.log("Geolocation not supported");
                            }
                        });
                    </script>
                @endscript
            </div>
            <div class="d-flex justify-content-center align-items-center col p-3">
                <button id="clockOutBtn" class="btn btn-primary btn-lg active mb-0 text-white" wire:click="clockOut" role="button"
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
                    Your clock-out time: {{ $clockOutTime ?? 'N/A' }}
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
