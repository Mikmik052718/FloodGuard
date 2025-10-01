<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Flood Hazard Maps</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="<?= base_url('assets/css/floodmaps.css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/css/Logo.css') ?>" />
</head>

<body>

<!-- 🔹 NAVBAR -->
<header>
    <a href="<?= site_url('home') ?>" class="logo">
                       
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke-width="3">
                       
                        <path d="M20 40a12 12 0 0 1 0-24 14 14 0 0 1 28 4h2a10 10 0 0 1 0 20H20z" fill="none"/>
                      
                        <line x1="24" y1="44" x2="20" y2="54"/>
                        <line x1="32" y1="44" x2="28" y2="54"/>
                        <line x1="40" y1="44" x2="36" y2="54"/>
                       
                        <path d="M16 58q4 4 8 0t8 0 8 0 8 0" fill="none"/>
                        </svg>

                        <div class="divider"></div>

                        <div class="logo-text">AlertoMarikeno</div>
                    </a>
    <div class="nav-links">
      <?php if (session()->get('logged_in')): ?>
        <span>
          Logged in as <strong><?= esc(session()->get('username')) ?></strong> | 
          <a href="<?= site_url('auth/logout') ?>" class="logout-link">Logout</a>
        </span>
      <?php endif; ?>
    </div>
  </header>

<div class="container">

    <!-- ✅ Session Check -->
    <?php if (session()->get('logged_in')): ?>
        
    <?php else: ?>
        <div class="user-info" style="border-left-color:#dc3545; background:#f8d7da;">
            <h4 style="color:#dc3545;">⚠️ No Active Session</h4>
            <p>You are viewing as a guest. <a href="<?= site_url('auth/uslogin') ?>">Login</a> to save your location.</p>
        </div>
    <?php endif; ?>

    <!-- 🔹 Title -->
    <h3>Flood Hazard Map</h3>

    <!-- 🔹 Map -->
    <div id="map"></div>

    <!-- 🔹 Location Controls -->
    <div class="location-controls">
        <button onclick="locateMe()" class="btn-primary">📍 Get My Location</button>
        <?php if (session()->get('logged_in')): ?>
            <button onclick="loadSavedLocation()" class="btn-warning">📂 Load Saved Location</button>
            <button onclick="saveCurrentLocation()" class="btn-success" id="saveLocationBtn" disabled>💾 Save Location</button>
        <?php endif; ?>
    </div>

    <!-- 🔹 Status -->
    <div id="locationStatus" class="location-status"></div>

    <!-- 🔹 Legend -->
    <div class="legend">
        <span class="low">Low Risk</span>
        <span class="medium">Medium Risk</span>
        <span class="high">High Risk</span>
    </div>

    <!-- 🔹 Info Footer -->
    <?php if (session()->get('logged_in')): ?>
        <div class="info-footer">
            <p><strong>Features:</strong> 📍 Get Current Location | 💾 Save | 📂 Load</p>
            <p>Your location is securely stored and linked to your account.</p>
        </div>
    <?php endif; ?>

</div>

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
        L.geoJSON(data, {
          style: function (feature) {
            const level = feature.properties.Flood_Hazard_Level;
            return {
              color: "#151515",
              weight: 0.3,
              fillColor: level === 1 ? "#28a745" : level === 2 ? "#ffc107" : "#dc3545",
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
        setTimeout(() => { statusDiv.style.display = 'none'; }, 5000);
    }

    function locateMe() {
        if (navigator.geolocation) {
            showStatus('🔍 Getting your location...', 'info');
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    currentLat = position.coords.latitude;
                    currentLon = position.coords.longitude;
                    if (currentLocationMarker) { map.removeLayer(currentLocationMarker); }
                    currentLocationMarker = L.marker([currentLat, currentLon]).addTo(map);
                    currentLocationMarker.bindPopup("📍 Your Current Location").openPopup();
                    map.setView([currentLat, currentLon], 15);
                    if (isLoggedIn) { document.getElementById('saveLocationBtn').disabled = false; }
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
        if (!isLoggedIn) { showStatus('❌ Please login to save your location', 'error'); return; }
        if (!currentLat || !currentLon) { showStatus('❌ Please get your current location first', 'error'); return; }
        showStatus('💾 Saving location...', 'info');
        const formData = new FormData();
        formData.append('lat', currentLat);
        formData.append('lon', currentLon);
        formData.append('hazard_level', 'GREEN');
        fetch('<?= site_url("flood/save-location") ?>', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') { showStatus('✅ ' + data.message, 'success'); }
            else { showStatus('❌ ' + data.message, 'error'); }
        })
        .catch(error => { showStatus('❌ Error saving location: ' + error.message, 'error'); });
    }

    function loadSavedLocation() {
        if (!isLoggedIn) { showStatus('❌ Please login to load saved location', 'error'); return; }
        showStatus('📂 Loading saved location...', 'info');
        fetch('<?= site_url("flood/get-location") ?>')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const location = data.location;
                if (savedLocationMarker) { map.removeLayer(savedLocationMarker); }
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
        .catch(error => { showStatus('❌ Error loading location: ' + error.message, 'error'); });
    }

    <?php if (session()->get('logged_in')): ?>
        setTimeout(loadSavedLocation, 1000);
    <?php endif; ?>
</script>

</body>
</html>
