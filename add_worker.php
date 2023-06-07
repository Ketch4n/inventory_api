<?php
// Establish database connection
include 'db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from Flutter app
$data = json_decode(file_get_contents('php://input'), true);
$wname = $data['username'];
$wpass = $data['password'];

// Insert data into the database
$sql = "INSERT INTO workers (username, password) VALUES ('$wname', '$wpass')";
if ($conn->query($sql) === TRUE) {
    $response = array("status" => "success", "message" => "Data inserted successfully");
} else {
    $response = array("status" => "error", "message" => "Error: " . $conn->error);
}

// Close database connection
$conn->close();

// Return response to Flutter app
header('Content-Type: application/json');
echo json_encode($response);
?>
