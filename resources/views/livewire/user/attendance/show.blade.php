<style>
    .btnclock {
        background-color: #0070ff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 12px;
    }

    .btnclock:hover {
        background-color: #0070ff;
        color: white;
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header min-height-250 border-radius-xl mt-4"
        style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <h3 class="text-white font-weight-bolder mx-6 mb-4 pt-2">Hello, {{ auth()->user()->name }}!</h3>
    </div>

    @include('livewire.user-on-this-page')

    <div class="container py-4 text-center">
        <p style="font-size: 24px; font-weight: bold;">Weekly Performance: <strong>{{ $weeklyStatus }}</strong></p>
    </div>

    <div class="card card-body blur shadow-blur mx-4">

        <!-- CLOCK BUTTONS -->
        <div class="m-3 row">
            <div class="d-flex justify-content-center align-items-center col p-3">
                <button wire:click="clockIn"
                    @if($isClockInDisabled) disabled @endif
                    class="btn btnclock btn-lg w-100 text-white"
                    style="height: 100%; font-size: 15px;">
                    Clock-in
                </button>
            </div>
            <div class="d-flex justify-content-center align-items-center col p-3">
                <button wire:click="clockOut"
                    @if($isClockOutDisabled) disabled @endif
                    class="btn btnclock btn-lg w-100 text-white"
                    style="height: 100%; font-size: 15px;">
                    Clock-out
                </button>
            </div>
        </div>

        <!-- ATTENDANCE SESSION INFO -->
        <div class="row">
            @if ($attendanceSession == 'ended')
                <h6 class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-7 pt-4">
                    Attendance Session: Ended <br>
                    Your clock-in time: {{ $clockInTime ?? 'N/A' }} <br>
                    Your clock-out time: {{ $clockOutTime ?? 'N/A' }} <br>
                    Your Clock-in point:
                    @php
                        $points = 0;
                        if ($clockInTime) {
                            $time = \Carbon\Carbon::parse($clockInTime);
                            $nine = $time->copy()->setTime(9, 0);
                            $nineThirty = $time->copy()->setTime(9, 30);
                            $ten = $time->copy()->setTime(10, 0);

                            if ($time->lte($nine)) {
                                $points = 50;
                            } elseif ($time->lte($nineThirty)) {
                                $points = 30;
                            } elseif ($time->lte($ten)) {
                                $points = 20;
                            } else {
                                $points = 0;
                            }
                        }

                        $workingHourPoints = 0;
                        if ($clockInTime && $clockOutTime) {
                            $in = \Carbon\Carbon::parse($clockInTime);
                            $out = \Carbon\Carbon::parse($clockOutTime);
                            $hoursWorked = $in->diffInHours($out);
                            $workingHourPoints = $hoursWorked >= 8 ? 50 : 0;
                        }
                    @endphp
                    {{ $points }} <br>
                    Your Working Hour Points: {{ $workingHourPoints }} <br>
                    Your Total Points: {{ ($points + $workingHourPoints) }} <br>
                </h6>
            @elseif ($attendanceSession == 'active')
                <h6 class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-7 pt-4">
                    Attendance Session: Active <br>
                    Your clock-in time: {{ $clockInTime ?? 'N/A' }}
                </h6>
            @else
                <h6 class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-7 pt-4">
                    Click CLOCK IN to start recording your attendance
                </h6>
            @endif
        </div>

        <!-- MAP COMPONENT -->
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

<!-- SWEETALERT2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- LIVEWIRE EVENT LISTENERS FOR SUCCESS ALERT -->
<script>
    Livewire.on('clockInSuccess', () => {
        Swal.fire({
            icon: 'success',
            title: 'Clock-In Successful',
            text: '✅ You have successfully clocked in!',
            confirmButtonColor: '#28a745'
        });
    });

    Livewire.on('clockOutSuccess', () => {
        Swal.fire({
            icon: 'success',
            title: 'Clock-Out Successful',
            text: '✅ You have successfully clocked out!',
            confirmButtonColor: '#dc3545'
        });
    });
</script>

