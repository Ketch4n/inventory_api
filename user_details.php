<?php

include 'db.php';



// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// User ID or username (replace with the actual value)
$userId = $_POST['id'];


// SQL query to fetch data for a single user
$sql = "SELECT * FROM users WHERE id = $userId";

// Execute the query
$result = $con->query($sql);

// Convert the result set to JSON
$response = array();
if ($result->num_rows > 0) {
    $response = $result->fetch_assoc();
}

// Close the connection
$con->close();

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
