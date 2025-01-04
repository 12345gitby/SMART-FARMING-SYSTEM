

import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import accuracy_score
import matplotlib.pyplot as plt
import seaborn as sns
import json
import mysql.connector
import time

# Database connection
db_connection = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',
    database='soilmonitoring'
)

# Dictionary to map each crop to its water requirement (in liters per day)
water_requirement_per_crop = {
    'rice': 10,
    'maize': 6.1,
    'chickpea': 3.5,
    'kidneybeans': 4,
    'pigeonpeas': 3,
    'mothbeans': 3.5,
    'mungbean': 3,
    'blackgram': 4,
    'lentil': 2.5,
    'pomegranate': 6,
    'banana': 8,
    'mango': 5,
    'grapes': 4,
    'watermelon': 10,
    'muskmelon': 8,
    'apple': 6,
    'orange': 8,
    'papaya': 6,
    'coconut': 7,
    'cotton': 5,
    'jute': 7,
    'coffee': 4
}


while True:
    # Fetch the last 7 entries from soil_data
    query = "SELECT nitrogen, phosphorus, potassium, temperature, humidity FROM soil_data ORDER BY id DESC LIMIT 7;"
    data_from_db = pd.read_sql(query, con=db_connection)

    # Calculate the average of the last 7 entries
    average_data = data_from_db.mean().tolist()
    arduino_sensor_data = average_data  # Use the average values for prediction
    data = pd.read_csv('my_flashk_api/prediction_model/Crop_recommendation.csv')

    # Check for missing values
    print(data.isnull().sum())

    # Prepare features (X) and target (y) without 'ph' and 'rainfall'
    X = data[['nitrogen', 'phosphorus', 'potassium', 'temperature', 'humidity']]
    y = data['label']

    # Encode the target variable (Favorable Crops)
    label_encoder = LabelEncoder()
    y_encoded = label_encoder.fit_transform(y)

    # Split the dataset into training and testing sets (80% train, 20% test)
    X_train, X_test, y_train, y_test = train_test_split(X, y_encoded, test_size=0.2, random_state=42)

    # Train the model using Random Forest Classifier
    model = RandomForestClassifier(n_estimators=100, random_state=42)
    model.fit(X_train, y_train)

    # Evaluate the model on the test set
    y_pred = model.predict(X_test)
    accuracy = accuracy_score(y_test, y_pred)
    print(f'Accuracy of the model: {accuracy * 100:.2f}%')

    # Feature Importance Visualization
    importances = model.feature_importances_
    features = X.columns

    # Plot the feature importance
    plt.figure(figsize=(10, 6))
    sns.barplot(x=importances, y=features)
    plt.title('Feature Importance in Crop Prediction')
    plt.xlabel('Importance')
    plt.ylabel('Features')
    plt.savefig('my_flashk_api/feature_extracted_img/feature_importance.png')

    # Function to predict crop based on sensor data from the database
    def predict_crop(sensor_data):
        # Create a DataFrame with the appropriate column names
        sensor_df = pd.DataFrame([sensor_data], columns=['nitrogen', 'phosphorus', 'potassium', 'temperature', 'humidity'])
        predicted_class = model.predict(sensor_df)  # Use the DataFrame for prediction
        crop = label_encoder.inverse_transform(predicted_class)
        return crop[0]

    predicted_crop = predict_crop(arduino_sensor_data)

    # Retrieve the water requirement for the predicted crop
    water_required = water_requirement_per_crop.get(predicted_crop, "Unknown")

    # Output the recommended crop along with favorable conditions and water required per day
    print(f'The recommended crop for the given conditions is: {predicted_crop}')
    print(f'The water required per day for {predicted_crop} is: {water_required} liters')

    # Save output to a JSON file for PHP integration
    output_data = {
        "model_accuracy": round(accuracy * 100, 2),
        "recommended_crop": predicted_crop,
        "water_required_per_day": water_required,
        "sensor_data": {
            "nitrogen": arduino_sensor_data[0],
            "phosphorus": arduino_sensor_data[1],
            "potassium": arduino_sensor_data[2],
            "temperature": arduino_sensor_data[3],
            "humidity": arduino_sensor_data[4]
        }
    }

    # Save the data to a JSON file
    with open('my_flashk_api/prediction_model/model_output.json', 'w') as json_file:
        json.dump(output_data, json_file, indent=4)

    print("Model output has been saved to 'model_output.json'.")
    
    # Wait for 1 minute before the next iteration
    time.sleep(60)
