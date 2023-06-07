<?php
// Database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "inventory";

// Create a connection
$connection = new mysqli($host, $username, $password, $database);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// User ID or username (replace with the actual value)
$userId = 1;

// SQL query to fetch data for a single user
$sql = "SELECT * FROM your_table WHERE user_id = $userId";

// Execute the query
$result = $connection->query($sql);

// Convert the result set to JSON
$response = array();
if ($result->num_rows > 0) {
    $response = $result->fetch_assoc();
}

// Close the connection
$connection->close();

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
