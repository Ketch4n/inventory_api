<?php
// Establish database connection
include 'db.php';
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get data from Flutter app
$data = json_decode(file_get_contents('php://input'), true);

// Extract the date from the data
$date = $data['date'];
$stock_id = $data['stock_id'];
$state = $data['state'];
$quantity = $data['quantity'];
$price = $data['price'];
$markup = $data['markup'];
$payment = $data['payment'];

// Convert the date to a valid SQL date format (assuming the date is in the format "yyyy-MM-dd HH:mm:ss")
$dateFormatted = date('Y-m-d H:i:s', strtotime($date));

$response = array();

// Insert data into the second table ("transactions")
// $state = 'in';
$sqlTransactions = "INSERT INTO transactions (stock_id, quantity,price,markup, payment,state, date) VALUES ('$stock_id', '$quantity','$price','$markup', '$payment','$state', '$dateFormatted')";

if ($con->query($sqlTransactions) === TRUE) {
    // Insertion successful
    $response["status"] = "success";
    $response["message"] = "Data inserted into the second table successfully";
} else {
    // Error occurred while inserting into the second table
    $response["status"] = "error";
    $response["message"] = "Error: Failed to insert data into the second table";
}

// Close database connection
$con->close();

// Return response to Flutter app
header('Content-Type: application/json');
echo json_encode($response);
?>
