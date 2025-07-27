import sys
import os
import json
import pandas as pd
import joblib
import xgboost as xgb
# Get input from stdin
input_data = json.load(sys.stdin)
new_data = pd.DataFrame([input_data])

# Feature engineering
new_data["rain_intensity"] = new_data["rain_sum (mm)"] / (new_data["precipitation_hours (h)"] + 0.1)
new_data["discharge_rain_ratio"] = new_data["river_discharge (m?/s)"] / (new_data["rain_sum (mm)"] + 0.1)
new_data["wind_rain_product"] = new_data["wind_gusts_10m_max (km/h)"] * new_data["rain_sum (mm)"]
new_data.fillna(new_data.mean(numeric_only=True), inplace=True)

# Absolute path to this script's folder
base_dir = os.path.dirname(os.path.abspath(__file__))
scaler_path = os.path.join(base_dir, "xgb_scaler.pkl")
model_path = os.path.join(base_dir, "xg_model.pkl")

# Debug (optional)
# print("Scaler path:", scaler_path)
# print("Model path:", model_path)

# Load model and scaler
scaler = joblib.load(scaler_path)
model = joblib.load(model_path)

# Predict
X_scaled = scaler.transform(new_data)
y_prob = model.predict_proba(X_scaled)[:, 1]
threshold = 0.4
y_pred = (y_prob >= threshold).astype(int)

# Output result as JSON
print(json.dumps({
    "probability": float(y_prob[0]),
    "prediction": "FLOOD" if y_pred[0] == 1 else "No Flood"
}))
