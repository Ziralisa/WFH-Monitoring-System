<div class="card-body px-0 pt-0 pb-2">
    <!-- Google Map container -->
    <input type="hidden" id="userHomeLat" value="{{ auth()->user()->home_lat ?? 0 }}">
    <input type="hidden" id="userHomeLng" value="{{ auth()->user()->home_lng ?? 0 }}">
    <div id="map" style="height: 400px; width: 100%;" wire:ignore></div>

    <!-- Last updated -->
    <div class="p-3 text-gray-900">
        Last updated: <span id="lastUpdated">N/A</span>
        <br>
        <em>*Note: Keep this page running at all time during attendance session!</em>
    </div>

    <script>
        let watchInstance;
        let map;
        let marker;
        let cityCircle;
        let lastPosition = null;
        let lastSaved = 0;
        // Retrieve the user's home location from hidden inputs
        const userHomeLat = parseFloat(document.getElementById('userHomeLat').value) || 0;
        const userHomeLng = parseFloat(document.getElementById('userHomeLng').value) || 0;
        const homePosition = {
            lat: userHomeLat,
            lng: userHomeLng,
        };

        // Initialize the map when the document is fully loaded
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("lastUpdated").textContent = "N/A";
        });

        // Listen for the start attendance session event triggered by clock-in
        window.addEventListener('start-attendance-session', (event) => {
            const sessionType = event.detail[0];
            trackUserLocation(sessionType); // Pass the actual value of sessionType
        });

        // Listen for the stop attendance session event triggered by clock-out
        window.addEventListener('stop-attendance-session', () => {
            stopTrackSession();
        });

        // Function to update the map to the current geolocation
        function trackUserLocation(sessionType) {
            if (navigator.geolocation) {
                if (sessionType == 'clock_in') {
                    //START SESSION CODE HERE..
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const userPosition = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };
                            const currentTime = Date.now();
                            lastSaved = currentTime;

                            //UPDATE MAPS
                            lastPosition = userPosition;
                            map.setCenter(userPosition);
                            marker.setPosition(userPosition);
                            marker.setTitle("User found!");
                            document.getElementById("lastUpdated").textContent = new Date().toLocaleString();

                            //TRANSITION INTO ACTIVE SESSION...
                            trackUserLocation('active');
                        },
                        () => {
                            console.log("Failed to retrieve location.");
                        }
                    );
                } else
                if (sessionType == 'active') {
                    //ACTIVE SESSION CODE
                    //watchInstance STARTS HERE..
                    watchInstance = navigator.geolocation.watchPosition(
                        (position) => {
                            const userPosition = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };

                            // Check if the position has changed significantly
                            const distanceMoved = lastPosition ? calculateDistance(lastPosition, userPosition) : 0;
                            const currentTime = Date.now();

                            // Determine range status
                            const isInRange = checkIfInRange(userPosition, homePosition);

                            // Save every time there's a significant move or after a set interval
                            if (distanceMoved > 50) { // 50 meters or 60 seconds
                                saveLocationToDatabase(userPosition, isInRange ? 1 : 0);
                                console.log("Location saved! Session active..");
                                lastSaved = currentTime;
                            } else if(currentTime - lastSaved > 60000){
                                //prompt user still there or not (button renew session or clockout)
                            }

                            else {
                                console.log("Location is not saved due to minimal/lack of movement!");
                            }

                            console.log("Distance moved from last position", distanceMoved, "meters.");
                            lastPosition = userPosition;
                            map.setCenter(lastPosition);
                            marker.setPosition(lastPosition);
                            marker.setTitle("User found!");
                            document.getElementById("lastUpdated").textContent = new Date().toLocaleString();
                        },
                        () => {
                            console.log("Failed to retrieve location");
                        }
                    );
                    //watchInstance ENDS HERE...
                }

            } else {
                console.log("Geolocation not supported");
            }
        }

        function checkIfInRange(userPosition, homePosition) {
            const maxDistance = 50; // Define the maximum range in meters (adjust this value as needed)
            const distance = calculateDistance(userPosition, homePosition);

            return distance <= maxDistance;
        }


        // Calculate the distance between two points (in meters)
        function calculateDistance(pos1, pos2) {
            const R = 6371e3; // Earth radius in meters
            const φ1 = pos1.lat * Math.PI / 180;
            const φ2 = pos2.lat * Math.PI / 180;
            const Δφ = (pos2.lat - pos1.lat) * Math.PI / 180;
            const Δλ = (pos2.lng - pos1.lng) * Math.PI / 180;

            const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return R * c; // Distance in meters
        }

        // Simulate saving the location to the database (e.g., via an AJAX request)
        function saveLocationToDatabase(position, rangeStatus) {
            const locationData = {
                latitude: position.lat,
                longitude: position.lng,
                in_range: rangeStatus,
            };
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/update-location-session', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify(locationData)
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Location saved", data);
                    const locationUpdatedEvent = new Event('location-updated');
                    window.dispatchEvent(locationUpdatedEvent);
                    const sendNotificationEvent = new CustomEvent('send-notification', {
                        "detail": {
                            "in_range": rangeStatus
                        }
                    })
                    window.dispatchEvent(sendNotificationEvent);
                })
                .catch(error => {
                    console.log("Error saving location", error);
                });
        }


        function initMap() {
            if (!map) { // Ensure the map is initialized only once
                const mapOptions = {
                    zoom: 17,
                    center: homePosition
                };
                map = new google.maps.Map(document.getElementById("map"), mapOptions);
                marker = new google.maps.Marker({
                    position: homePosition,
                    map: map,
                    title: "Welcome to KL CENTRAL",
                });
                var sunCircle = {
                    strokeColor: "#c3fc49",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#c3fc49",
                    fillOpacity: 0.35,
                    map: map,
                    center: homePosition,
                    radius: 50 // in meters
                };
                cityCircle = new google.maps.Circle(sunCircle);
            }
        }

        // Expose the initMap function to the window object for Google Maps
        window.initMap = initMap;
    </script>

    <!-- Load Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaVipOWWCixCZQeOCuFhvVOQ71_mN8qq4&callback=initMap" async
        defer></script>
</div>
