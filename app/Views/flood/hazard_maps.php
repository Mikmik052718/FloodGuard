<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <title>Flood Hazard Maps</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .user-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        .user-info h4 {
            margin: 0 0 10px 0;
            color: #007bff;
        }
        .result {
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .flood {
            background-color: #ffe5e5;
            color: #b30000;
        }
        .no-flood {
            background-color: #e6f7ff;
            color: #0077b6;
        }
        .info {
            margin-top: 20px;
            font-size: 14px;
            text-align: left;
        }
        .location-controls {
            margin: 15px 0;
            text-align: center;
        }
        .location-controls button {
            margin: 5px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .location-status {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .status-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .status-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>

<!-- Session Check and User Info -->
<?php if (session()->get('logged_in')): ?>
    <a href="<?= site_url('auth/logout') ?>" class="logout-btn">Logout</a>

    <div class="user-info">
        <h4>👤 Welcome, <?= esc(session()->get('username')) ?>!</h4>
        <p><strong>User ID:</strong> <?= esc(session()->get('user_id')) ?></p>
        <p><strong>Role:</strong> <?= esc(session()->get('role')) ?></p>
        <p><strong>Session Active:</strong> ✅ Yes</p>
    </div>
<?php else: ?>
    <div class="user-info" style="border-left-color: #dc3545; background-color: #f8d7da;">
        <h4 style="color: #dc3545;">⚠️ No Active Session</h4>
        <p>You are viewing this page as a guest. <a href="<?= site_url('auth/uslogin') ?>">Login</a> to save your location and get personalized alerts.</p>
    </div>
<?php endif; ?>

<h3 style="text-align:center;">Flood Hazard Map</h3>
<div id="map" style="height: 400px; margin-top: 20px;"></div>

<!-- Location Controls -->
<div class="location-controls">
    <button onclick="locateMe()" class="btn-primary">📍 Get My Current Location</button>
    <?php if (session()->get('logged_in')): ?>
        <button onclick="loadSavedLocation()" class="btn-warning">📂 Load Saved Location</button>
        <button onclick="saveCurrentLocation()" class="btn-success" id="saveLocationBtn" disabled>💾 Save Current Location</button>
    <?php endif; ?>
</div>

<!-- Location Status Display -->
<div id="locationStatus" class="location-status" style="display: none;"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([14.65, 121.1], 13);
    var currentLocationMarker = null;
    var savedLocationMarker = null;
    var currentLat = null;
    var currentLon = null;
    var isLoggedIn = <?= session()->get('logged_in') ? 'true' : 'false' ?>;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 15
    }).addTo(map);

    // Load flood zones
    fetch("<?= base_url('flood_zones_simplified.geojson') ?>")
      .then(res => res.json())
      .then(data => {
        console.log("GeoJSON loaded:", data);
        L.geoJSON(data, {
          style: function (feature) {
            const level = feature.properties.Flood_Hazard_Level;
            return {
              color: "#151515",
              weight: 0.3,
              fillColor: level === 1 ? "#00ff00" : level === 2 ? "#ffff00" : "#ff0000",
              fillOpacity: 0.5
            };
          },
          onEachFeature: function (feature, layer) {
            layer.bindPopup("Flood Hazard Level: " + feature.properties.Flood_Hazard_Level);
          }
        }).addTo(map);
      });

    function showStatus(message, type) {
        const statusDiv = document.getElementById('locationStatus');
        statusDiv.className = 'location-status status-' + type;
        statusDiv.textContent = message;
        statusDiv.style.display = 'block';

        // Auto-hide after 5 seconds
        setTimeout(() => {
            statusDiv.style.display = 'none';
        }, 5000);
    }

    function locateMe() {
        if (navigator.geolocation) {
            showStatus('🔍 Getting your location...', 'info');

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    currentLat = position.coords.latitude;
                    currentLon = position.coords.longitude;

                    // Remove existing current location marker
                    if (currentLocationMarker) {
                        map.removeLayer(currentLocationMarker);
                    }

                    // Add new marker
                    currentLocationMarker = L.marker([currentLat, currentLon]).addTo(map);
                    currentLocationMarker.bindPopup("📍 Your Current Location").openPopup();

                    map.setView([currentLat, currentLon], 15);

                    // Enable save button if logged in
                    if (isLoggedIn) {
                        document.getElementById('saveLocationBtn').disabled = false;
                    }

                    showStatus('✅ Location found: ' + currentLat.toFixed(6) + ', ' + currentLon.toFixed(6), 'success');
                },
                function (error) {
                    showStatus('❌ Geolocation failed: ' + error.message, 'error');
                }
            );
        } else {
            showStatus('❌ Geolocation is not supported by this browser', 'error');
        }
    }

    function saveCurrentLocation() {
        if (!isLoggedIn) {
            showStatus('❌ Please login to save your location', 'error');
            return;
        }

        if (!currentLat || !currentLon) {
            showStatus('❌ Please get your current location first', 'error');
            return;
        }

        showStatus('💾 Saving location...', 'info');

        // Create form data
        const formData = new FormData();
        formData.append('lat', currentLat);
        formData.append('lon', currentLon);
        formData.append('hazard_level', 'GREEN'); // Default hazard level

        fetch('<?= site_url("flood/save-location") ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showStatus('✅ ' + data.message, 'success');
            } else {
                showStatus('❌ ' + data.message, 'error');
            }
        })
        .catch(error => {
            showStatus('❌ Error saving location: ' + error.message, 'error');
        });
    }

    function loadSavedLocation() {
        if (!isLoggedIn) {
            showStatus('❌ Please login to load saved location', 'error');
            return;
        }

        showStatus('📂 Loading saved location...', 'info');

        fetch('<?= site_url("flood/get-location") ?>')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const location = data.location;

                // Remove existing saved location marker
                if (savedLocationMarker) {
                    map.removeLayer(savedLocationMarker);
                }

                // Add saved location marker
                savedLocationMarker = L.marker([location.lat, location.lon]).addTo(map);
                savedLocationMarker.bindPopup(
                    `💾 Saved Location<br>
                     Hazard Level: ${location.hazard_level || 'Unknown'}<br>
                     Last Updated: ${location.last_checked_at}`
                ).openPopup();

                map.setView([location.lat, location.lon], 15);

                showStatus('✅ Saved location loaded: ' + location.lat + ', ' + location.lon, 'success');
            } else {
                showStatus('❌ ' + data.message, 'error');
            }
        })
        .catch(error => {
            showStatus('❌ Error loading location: ' + error.message, 'error');
        });
    }

    // Auto-load saved location if user is logged in
    <?php if (session()->get('logged_in')): ?>
        // Load saved location on page load
        setTimeout(loadSavedLocation, 1000);
    <?php endif; ?>
</script>

<div style="text-align:center; margin-top: 10px;">
  <strong>Flood Risk Legend:</strong><br>
  <span style="color:#00cc00;">■ Low</span>
  <span style="color:#ffcc00;">■ Medium</span>
  <span style="color:#ff3300;">■ High</span>
</div>

<?php if (session()->get('logged_in')): ?>
    <div style="text-align:center; margin-top: 15px; font-size: 12px; color: #666;">
        <p><strong>Location Features:</strong></p>
        <p>📍 Get Current Location | 💾 Save Location to Database | 📂 Load Previously Saved Location</p>
        <p>Your location data is securely stored and linked to your user account.</p>
    </div>
<?php endif; ?>

</body>
</html>
