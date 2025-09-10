import sys
import os
import json
import pandas as pd
import joblib
import warnings

warnings.filterwarnings("ignore")  # suppress sklearn/xgboost version warnings

# --- 1. Load scaler + model ---
BASE_DIR    = os.path.dirname(os.path.abspath(__file__))
SCALER_PATH = os.path.join(BASE_DIR, "xgbhs_scaler.pkl")
MODEL_PATH  = os.path.join(BASE_DIR, "xgbhm_model.pkl")

scaler = joblib.load(SCALER_PATH)
model  = joblib.load(MODEL_PATH)

# --- 2. Read input data from CI4 (list of dicts) ---
inputs = json.load(sys.stdin)  # [{"rain": 0.3, "temperature_2m": 25.6, ...}, ...]

# --- 3. Define expected features from training ---
expected_features = scaler.feature_names_in_

# --- 4. Forecast → Historical → Model Feature Mapping ---
# This dictionary handles both API variations
column_mapping = {
    # precipitation
    "precipitation": "rain",              # forecast API: total precip
    "rain": "rain",                       # historical API
    "rain (mm)": "rain",                  # fallback naming

    # temperature
    "temperature_2m": "temperature_2m",   # both APIs
    "temp (°C)": "temperature_2m",        # fallback

    # soil moisture
    "soil_moisture_0_1cm": "soil_moisture_0_to_7cm",
    "soil_moisture_1_3cm": "soil_moisture_0_to_7cm",  # merge into 0–7cm
    "soil_moisture_3_9cm": "soil_moisture_0_to_7cm",
    "soil_moisture_9_27cm": "soil_moisture_7_to_28cm",
    "soil_moisture_27_81cm": "soil_moisture_28_to_100cm",
    "soil_moisture_100_255cm": "soil_moisture_100_to_255cm",

    # weather code
    "weathercode": "weather_code",
    "weather_code (wmo code)": "weather_code",

    # discharge (if available in dataset)
    "daily_discharge": "daily_discharge",
    "river_discharge (m³/s)": "daily_discharge",
}

# --- 5. Process each row ---
results = []

for row in inputs:
    df = pd.DataFrame([row])

    # map columns
    df.rename(columns=column_mapping, inplace=True)

    # add missing expected features
    for feat in expected_features:
        if feat not in df.columns:
            df[feat] = 0  # default filler

    # enforce column order
    df = df[expected_features]

    # fill NaNs
    df.fillna(0, inplace=True)

    # scale + predict
    X_scaled = scaler.transform(df)
    prob     = model.predict_proba(X_scaled)[:, 1][0]
    pred     = int(prob >= 0.4)

    results.append({
        "probability": round(float(prob), 4),
        "prediction": "FLOOD" if pred else "No Flood"
    })

# --- 6. Return JSON output ---
print(json.dumps(results))
