import sys
import os
import json
import pandas as pd
import joblib
import warnings

warnings.filterwarnings("ignore")  # suppress sklearn/xgboost version warnings

# 1.  Locate and load the scaler + XGBoost model just once

BASE_DIR    = os.path.dirname(os.path.abspath(__file__))
SCALER_PATH = os.path.join(BASE_DIR, "xgb_scaler.pkl")
MODEL_PATH  = os.path.join(BASE_DIR, "xg_model.pkl")

scaler = joblib.load(SCALER_PATH)
model  = joblib.load(MODEL_PATH)


# 2.  Read list‑of‑dicts from stdin (CI4 controller sends 5 days!)

inputs = json.load(sys.stdin)           # e.g. [{"field":value, ...}, … x5]

results = []


# 3.  Loop through each day, apply same feature‑engineering, predict

for row in inputs:
    df = pd.DataFrame([row])

    # --- feature engineering identical to training ---
    df["rain_intensity"]       = df["rain_sum (mm)"] / (df["precipitation_hours (h)"] + 0.1)
    df["discharge_rain_ratio"] = df["river_discharge (m?/s)"] / (df["rain_sum (mm)"] + 0.1)
    df["wind_rain_product"]    = df["wind_gusts_10m_max (km/h)"] * df["rain_sum (mm)"]
    df.fillna(df.mean(numeric_only=True), inplace=True)

    # scale & predict
    X_scaled = scaler.transform(df)
    prob     = model.predict_proba(X_scaled)[:, 1][0]
    pred     = int(prob >= 0.4)

    results.append({
        "probability": round(float(prob), 4),
        "prediction":  "FLOOD" if pred else "No Flood"
    })

# 4.  Print array‑of‑results as JSON for the CI4 controller

print(json.dumps(results))
