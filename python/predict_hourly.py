import sys
import os
import json
import pandas as pd
import joblib
import warnings
import numpy as np

warnings.filterwarnings("ignore")

# --- CONFIGURATION: SENSITIVITY FACTOR ---
# 1.0 = No Boost (Raw Model Output)
# 0.8 = Mild Boost (Slightly more sensitive)
# 0.5 = Strong Boost (Square Root - Recommended for flood safety)
# 0.3 = Extreme Boost (Very Paranoid)
SENSITIVITY_FACTOR = 0.7
# -----------------------------------------

# --- 1. Load Model + Pipeline ---
BASE_DIR          = os.path.dirname(os.path.abspath(__file__))
# Note: We load the Preprocessor Pipeline now, not just the Scaler
PREPROCESSOR_PATH = os.path.join(BASE_DIR, "xgbh_preprocessor.pkl")
MODEL_PATH        = os.path.join(BASE_DIR, "xgbhm_model.pkl")

preprocessor = joblib.load(PREPROCESSOR_PATH)
model        = joblib.load(MODEL_PATH)

# --- 2. Read Input Data ---
try:
    inputs = json.load(sys.stdin)
except ValueError:
    inputs = []

if not isinstance(inputs, list):
    inputs = [inputs]

# --- 3. Get Expected Features from the Pipeline ---
# We look at the 'scaler' step inside the pipeline to get the final feature names
# or the 'imputer' step if available.
try:
    # Attempt to get features from the scaler step
    expected_features = preprocessor.named_steps['scaler'].feature_names_in_
except AttributeError:
    # Fallback: if feature_names_in_ isn't saved (older sklearn versions), 
    # you might need to hardcode the list based on your X_train columns.
    # Based on your code, this should work.
    expected_features = preprocessor.feature_names_in_

# --- 4. Define Mapping (API -> Training Columns) ---
column_mapping = {
    # Precipitation
    "precipitation": "rain",
    "rain": "rain",
    "rain (mm)": "rain",
    
    # Temperature
    "temperature_2m": "temperature_2m",
    "temp (°C)": "temperature_2m",
    
    # Soil Moisture Aggregation
    "soil_moisture_0_1cm": "soil_moisture_0_to_7cm",
    "soil_moisture_1_3cm": "soil_moisture_0_to_7cm",
    "soil_moisture_3_9cm": "soil_moisture_0_to_7cm",
    "soil_moisture_9_27cm": "soil_moisture_7_to_28cm",
    "soil_moisture_27_81cm": "soil_moisture_28_to_100cm",
    "soil_moisture_100_255cm": "soil_moisture_100_to_255cm",
    
    # Weather Code
    "weathercode": "weather_code",
    "weather_code (wmo code)": "weather_code",
}

# --- 5. Process Each Row ---
results = []

for row in inputs:
    try:
        df = pd.DataFrame([row])

        # A. Rename columns
        df.rename(columns=column_mapping, inplace=True)

        # B. Smart Reindexing (The Critical Fix)
        # This forces the dataframe to have EXACTLY the columns the model expects.
        # If a column is missing (e.g., 'soil_moisture_7_to_28cm'), pandas creates it
        # and fills it with NaN (Not a Number).
        df = df.reindex(columns=expected_features)

        # C. Transform using the Pipeline
        # The Pipeline sees the NaNs created in step B, and the SimpleImputer
        # inside automatically fills them with the correct training mean.
        X_processed = preprocessor.transform(df)

        # D. Predict
        # A. Get Raw Probability
        raw_prob = model.predict_proba(X_processed)[:, 1][0]

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
            "prediction": "ERROR",
            "debug": "Failed during transformation or prediction"
        })

# --- 6. Output ---
print(json.dumps(results))