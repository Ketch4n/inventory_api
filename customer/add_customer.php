<?php
// Establish database connection
include '../db/database.php';
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get data from Flutter app
$data = json_decode(file_get_contents('php://input'), true);

// Extract data from the data
$own = $data['name'];
$str = $data['store'];
$gps = $data['location'];


// Insert data into the "category" table
$sqlCategory = "INSERT INTO customers (name,store,location) VALUES ('$own','$str','$gps')";

$response = array();

// Perform the insertion into the "category" table
if ($con->query($sqlCategory) === TRUE) {
    // Category insertion successful
    $response["status"] = "success";
    $response["message"] = "Data inserted into the 'customer' table successfully";
} else {
    // Error occurred while inserting into the "category" table
    $response["status"] = "error";
    $response["message"] = "Error: Failed to insert data into the 'customer' table";
}

// Close database connection
$con->close();

// Return response to Flutter app
header('Content-Type: application/json');
echo json_encode($response);
?>
