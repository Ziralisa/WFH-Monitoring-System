<div class="card-header pb-0 px-3">
    <h6 class="mb-0">{{ __('Job Information') }}</h6>
</div>
<div class="card-body pt-4 p-3">
    <div class="row">

        <div class="col-md-6">
            <div class="form-group">
                <label for="user-id" class="form-control-label">{{ __('Employee ID') }}</label>
                <input value="{{ $user->id }}" class="form-control" type="text" id="user-id" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-job-status" class="form-control-label">{{ __('Employment Status') }}</label>
                <div class="@error('user.job_status')border border-danger rounded-3 @enderror">
                    <select wire:model="user.job_status" class="form-control" id="user-job-status" disabled>
                        <option value="">Select Employment Status</option>
                        <option value="0">Employed</option>
                        <option value="1">Resigned</option>
                    </select>
                </div>
                @error('user.job_status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-position" class="form-control-label">{{ __('Position') }}</label>
                <div class="@error('user.position')border border-danger rounded-3 @enderror">
                    <input wire:model="user.position" class="form-control" type="text" id="user-position"
                        placeholder="Programmer" {{ $selectedUserId ? 'disabled' : '' }}>
                </div>
                @error('user.position')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-started_work" class="form-control-label">{{ __('Started Work') }}</label>
                <div class="@error('user.started_work')border border-danger rounded-3 @enderror">
                    <input wire:model="user.started_work" class="form-control" type="date" id="user-started_work"
                        {{ $selectedUserId ? 'disabled' : '' }}>
                </div>
                @error('user.started_work')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-work_email" class="form-control-label">{{ __('Work Email Address') }}</label>
                <div class="@error('user.work_email')border border-danger rounded-3 @enderror">
                    <input wire:model="user.work_email" class="form-control" type="email" id="user-work_email"
                        placeholder="youremail@example.com" {{ $selectedUserId ? 'disabled' : '' }}>
                </div>
                @error('user.work_email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-work_phone" class="form-control-label">{{ __('Work Phone Number') }}</label>
                <div class="@error('user.work_phone')border border-danger rounded-3 @enderror">
                    <input wire:model="user.work_phone" class="form-control" type="tel" id="user-work_phone"
                        placeholder="e.g: 012-345-6789" {{ $selectedUserId ? 'disabled' : '' }}>
                </div>
                @error('user.work_phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

{{-- SET WFH LOCATION --}}
@if (!$selectedUserId)
    <div class="container p-3">
        <div class="row">
            <div class="d-flex justify-content-center align-items-center col">
                <label class="form-control-label">{{ __('Work From Home Location') }}</label>
            </div>
        </div>
        <div class="row">
            <div class="d-flex justify-content-center">
                <div class="d-flex justify-content-center col-md-4">
                    <button type="button" class="btn btn-lg w-100 bg-gradient-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#modal-default">
                        <span class="btn-inner--icon"><i class="fa-solid fa-map-location-dot px-1"></i></span>
                        Set Location
                    </button>
                    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog"
                        aria-labelledby="modal-default" aria-hidden="true">
                        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="modal-title-default">Select your home location</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Hidden input fields to store user's home latitude and longitude -->
                                    <input type="hidden" id="userHomeLat"
                                        value="{{ auth()->user()->home_lat ?? 0 }}">
                                    <input type="hidden" id="userHomeLng"
                                        value="{{ auth()->user()->home_lng ?? 0 }}">
                                    <!-- Google Map container -->
                                    <div id="map" style="height: 246px; width: 100%;" wire:ignore></div>
                                    <div class="pt-3">
                                        <h6>Current Marker's Location:</h6>
                                        <p><span id="onIdlePositionView"></span></p>
                                        <h6>Selected Location:</h6>
                                        <p><span id="onClickPositionView"></span></p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="saveLocationBtn" type="button" class="btn bg-gradient-primary">Save
                                        changes</button>
                                    <button id="selectLocationBtn" type="button" class="btn btn-secondary">Select
                                        Location</button>
                                    <button type="button" class="btn btn-link  ml-auto"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endif


</div>
<script>
    var lp;
    var selectedLocation = null;

    function initMap() {
        // Retrieve the user's home location from hidden inputs
        const userHomeLat = parseFloat(document.getElementById('userHomeLat').value) || 0;
        const userHomeLng = parseFloat(document.getElementById('userHomeLng').value) || 0;
        const homeLatLng = {
            lat: userHomeLat,
            lng: userHomeLng,
        };

        lp = new locationPicker('map', {
            lat: userHomeLat,
            lng: userHomeLng,
        }, {
            zoom: 17
        });

        // Create the circle object
        var sunCircle = {
            strokeColor: "#c3fc49",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#c3fc49",
            fillOpacity: 0.35,
            map: lp.map, // Bind the circle to the lp map
            center: homeLatLng, // Initial center
            radius: 50 // in meters
        };

        cityCircle = new google.maps.Circle(sunCircle);

        // Bind the circle's center to the location picker position
        //cityCircle.bindTo('center', lp, 'position');

        // Create the control button to center the map
        const controlButton = document.createElement("button");

        // Set CSS for the control.
        controlButton.style.backgroundColor = "#fff";
        controlButton.style.border = "2px solid #fff";
        controlButton.style.borderRadius = "3px";
        controlButton.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
        controlButton.style.color = "rgb(25,25,25)";
        controlButton.style.cursor = "pointer";
        controlButton.style.fontFamily = "Roboto,Arial,sans-serif";
        controlButton.style.fontSize = "16px";
        controlButton.style.lineHeight = "38px";
        controlButton.style.margin = "8px 0 22px";
        controlButton.style.padding = "0 5px";
        controlButton.style.textAlign = "center";
        controlButton.textContent = "Pan to Home📍";
        controlButton.title = "Click to recenter the map";
        controlButton.type = "button";

        // Setup the click event listener to recenter the map
        controlButton.addEventListener("click", () => {
            lp.map.setCenter({
                lat: userHomeLat,
                lng: userHomeLng
            });
        });

        // Create the DIV to hold the control.
        const centerControlDiv = document.createElement("div");
        // Append the button to the DIV.
        centerControlDiv.appendChild(controlButton);
        lp.map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);

        google.maps.event.addListener(lp.map, 'idle', function(event) {
            // Get current location and show it in HTML
            var location = lp.getMarkerPosition();
            cityCircle.setCenter(lp.getMarkerPosition());
            console.log("Moved! Changed coordinates");
            document.getElementById('onIdlePositionView').innerHTML = 'Latitude: ' + location.lat +
                'Longitude: ' + location.lng;
        });
    }

    // Listen to button onclick event to select location
    document.getElementById('selectLocationBtn').onclick = function() {
        selectedLocation = lp.getMarkerPosition();
        document.getElementById('onClickPositionView').innerHTML = 'Latitude: ' + selectedLocation.lat +
            'Longitude: ' + selectedLocation.lng;
    };

    // Function to save user's location
    function saveUserLocation() {
        if (!selectedLocation) {
            console.log("No location selected to save.");
            return;
        }

        const locationData = {
            home_lat: selectedLocation.lat,
            home_lng: selectedLocation.lng,
        };

        // Fetch CSRF token from meta tag
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/save-location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify(locationData)
            })
            .then(response => response.json())
            .then(data => {
                console.log("User location saved!");
                window.location.href = '/user-profile';
            })
            .catch(error => {
                console.log("Error saving location", error);
            });
    }

    // Button to save new home location
    document.getElementById('saveLocationBtn').onclick = function() {
        if (confirm("Confirm save new home location?")) {
            saveUserLocation();
        } else {
            console.log("Cancelled!");
        }
    };
</script>
<script src="https://unpkg.com/location-picker/dist/location-picker.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaVipOWWCixCZQeOCuFhvVOQ71_mN8qq4&callback=initMap" async
    defer></script>
