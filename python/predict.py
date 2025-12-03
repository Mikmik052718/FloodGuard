import sys
import os
import json
import pandas as pd
import joblib
import warnings

warnings.filterwarnings("ignore")  # suppress sklearn/xgboost version warnings

# --- CONFIGURATION: SENSITIVITY FACTOR ---
# 1.0 = No Boost (Raw Model Output)
# 0.8 = Mild Boost (Slightly more sensitive)
# 0.5 = Strong Boost (Square Root - Recommended for flood safety)
# 0.3 = Extreme Boost (Very Paranoid)
SENSITIVITY_FACTOR = 0.7
# -----------------------------------------

# 1. Locate and load the scaler + XGBoost model just once
BASE_DIR    = os.path.dirname(os.path.abspath(__file__))
SCALER_PATH = os.path.join(BASE_DIR, "xgb_scaler.pkl")
MODEL_PATH  = os.path.join(BASE_DIR, "xg_model.pkl")

scaler = joblib.load(SCALER_PATH)
model  = joblib.load(MODEL_PATH)

# 2. Read list-of-dicts from stdin
try:
    inputs = json.load(sys.stdin)
except ValueError:
    inputs = [] # Handle empty input gracefully

if not isinstance(inputs, list):
    inputs = [inputs]

results = []

# 3. Loop through each day
for row in inputs:
    try:
        df = pd.DataFrame([row])

        # --- feature engineering identical to training ---
        # Ensure your API input keys match these calculations exactly
        df["rain_intensity"]       = df["rain_sum (mm)"] / (df["precipitation_hours (h)"] + 0.1)
        df["discharge_rain_ratio"] = df["river_discharge (m?/s)"] / (df["rain_sum (mm)"] + 0.1)
        df["wind_rain_product"]    = df["wind_gusts_10m_max (km/h)"] * df["rain_sum (mm)"]
        
        # Fill NaNs with mean
        df.fillna(df.mean(numeric_only=True), inplace=True)

        # --- Scale & Predict ---
        X_scaled = scaler.transform(df)
        
        # A. Get Raw Probability
        raw_prob = model.predict_proba(X_scaled)[:, 1][0]
        
        # B. Apply Sensitivity Factor (The Boost)
        # Formula: prob = raw_prob ^ factor
        boosted_prob = raw_prob ** SENSITIVITY_FACTOR

        # C. Make Decision
        # Since we boosted the probability, we standardize the threshold to 0.5
        pred = int(boosted_prob >= 0.5)

        results.append({
            "original_prob": round(float(raw_prob), 4),   # Useful for debugging
            "probability":   round(float(boosted_prob), 4), # The boosted value
            "factor_used":   SENSITIVITY_FACTOR,
            "prediction":    "FLOOD" if pred else "No Flood"
        })
        
    except Exception as e:
        results.append({
            "error": str(e),
            "prediction": "ERROR"
        })

# 4. Print results
print(json.dumps(results))