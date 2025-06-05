<div class="card-body px-0 pt-0 pb-2">

    <!-- Google map container -->
    <div id="map" style="height: 400px; width: 100%;" wire:ignore></div>

    <!-- Last updated -->
    <div class="p-3 text-gray-900">
        Last updated: <span id="lastUpdated">N/A</span><br>
        <em>*Notes: Keep this page running at all times during the attendance session!</em>
    </div>

    <script>
        let watchInstance = null;
        let map = null;
        let marker = null;
        let lastPosition = null;
        let lastSaved = 0;

        document.addEventListener("livewire:load", function () {
            if (typeof initMap === "function") {
                initMap();
            }
        });

        window.addEventListener('start-attendance-session', (event) => {
            const sessionType = event.detail[0];
            trackUserLocation(sessionType);
        });

        window.addEventListener('stop-attendance-session', () => {
            stopTrackSession();
        });

        function trackUserLocation(sessionType) {
            if (!navigator.geolocation) {
                alert("Geolocation is not supported by your browser.");
                console.log("Geolocation not supported.");
                return;
            }

            if (sessionType !== 'active') {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userPosition = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };
                        lastSaved = Date.now();

                        // Always mark as in range
                        saveLocationToDatabase(userPosition);

                        updateMap(userPosition);
                        document.getElementById("lastUpdated").textContent = new Date().toLocaleString();

                        // Start active tracking after initial fix
                        trackUserLocation("active");
                    },
                    (error) => {
                        console.error("Failed to retrieve location:", error);
                        alert("Unable to retrieve your location. Please allow location access.");
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                // Continuous tracking
                watchInstance = navigator.geolocation.watchPosition(
                    (position) => {
                        const userPosition = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };

                        const distanceMoved = lastPosition ? calculateDistance(lastPosition, userPosition) : 0;
                        const currentTime = Date.now();

                        if (distanceMoved > 10 || currentTime - lastSaved > 60000) {
                            saveLocationToDatabase(userPosition);
                            lastSaved = currentTime;
                            console.log("Location updated.");
                        }

                        lastPosition = userPosition;
                        updateMap(userPosition);
                        document.getElementById("lastUpdated").textContent = new Date().toLocaleString();
                    },
                    (error) => {
                        console.error("Failed to retrieve live location:", error);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            }
        }

        function stopTrackSession() {
            if (watchInstance !== null) {
                navigator.geolocation.clearWatch(watchInstance);
                watchInstance = null;
                console.log("Tracking stopped.");
            }
        }

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

            return R * c;
        }

        function saveLocationToDatabase(position) {
            const locationData = {
                latitude: position.lat,
                longitude: position.lng,
                in_range: 1 // Force in range
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
                console.log("Location saved:", data);

                // Notify Livewire
                window.dispatchEvent(new Event('location-updated'));

                // Additional event for notification if needed
                window.dispatchEvent(new CustomEvent('send-notification', { detail: { in_range: 1 }}));
            })
            .catch(error => {
                console.error("Error saving location", error);
            });
        }

        function updateMap(position) {
            if (!map) {
                const mapOptions = {
                    zoom: 17,
                    center: position,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                };

                map = new google.maps.Map(document.getElementById("map"), mapOptions);

                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: "Your Location",
                });
            } else {
                map.setCenter(position);
                marker.setPosition(position);
                marker.setTitle("Updated Location");
            }
        }

        function initMap() {
            if (!navigator.geolocation) {
                console.log("Geolocation not supported.");
                return;
            }

            navigator.geolocation.getCurrentPosition(function (position) {
                const currentPosition = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                updateMap(currentPosition);
            }, (error) => {
                console.error("Geolocation error:", error);
                alert("Please allow location access.");
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            });
        }

        window.initMap = initMap;
    </script>

    <!-- Load Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaVipOWWCixCZQeOCuFhvVOQ71_mN8qq4&callback=initMap" async defer></script>
</div>