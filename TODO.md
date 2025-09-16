# TODO: Update FloodGuard Views and Routes

## Tasks
- [x] Add guest session message to flood/daily view (predict_page.php)
- [x] Add guest session message to flood/hourly view (predict_result_hourly.php)
- [x] Rename predict-with-session to hazard-maps
  - [x] Rename view file predict_result_with_session.php to hazard_maps.php
  - [x] Remove data table from hazard_maps.php, keep only the map
  - [x] Update controller method predictWithSession to hazardMaps
  - [x] Update route from flood/predict-with-session to flood/hazard-maps
- [ ] Test the changes
