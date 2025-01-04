<?php
// Database connection details
$servername = "localhost";  // Change this if necessary
$username = "root";         // Your database username
$password = "Jay@2003";             // Your database password
$dbname = "soilmonitoring"; // Your database name for soil monitoring

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if data is received via GET request
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Retrieve data from GET request and ensure it's properly sanitized
    $humidity_value = isset($_GET['humidity']) ? floatval($_GET['humidity']) : 0;  // Default to 0 if missing
    $moisture_value = isset($_GET['moisture']) ? floatval($_GET['moisture']) : null;
    $temperature_value = isset($_GET['temperature']) ? floatval($_GET['temperature']) : null;
    $nitrogen_value = isset($_GET['nitrogen']) ? intval($_GET['nitrogen']) : null;
    $phosphorus_value = isset($_GET['phosphorus']) ? floatval($_GET['phosphorus']) : null;
    $potassium_value = isset($_GET['potassium']) ? floatval($_GET['potassium']) : null;

    // Validate data (check if none of the values are null)
    if ($moisture_value !== null && $temperature_value !== null && $nitrogen_value !== null && $phosphorus_value !== null && $potassium_value !== null && $humidity_value !== null) {
        // Prepare and bind the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO soil_data(moisture,temperature,nitrogen,phosphorus,potassium,humidity,timestamp) 
                                VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ddidds", $moisture_value, $temperature_value, $nitrogen_value, $phosphorus_value, $potassium_value, $humidity_value);

        // Execute the query and check for success
        if ($stmt->execute()) {
            echo "Data inserted successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "All fields must be filled with valid data.";
    }
} else {
    echo "No GET data received.";
}

// Close the database connection
$conn->close();
?>
