<?php
include '../db/database.php';

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
// Get data from Flutter app
$data = json_decode(file_get_contents('php://input'), true);

// Extract the date from the data
$item = $data['item'];
$category = $data['category'];
$type = $data['type'];
$price = $data['price'];
$markup = $data['markup'];
$date = $data['date'];
$dateFormatted = date('Y-m-d H:i:s', strtotime($date));

$quantity = $data['item_quantity'];

// Insert data into the first table ("stocks")
$sqlStocks = "INSERT INTO stocks (item, category,type, price,markup, date) VALUES ('$item', '$category', '$type','$price','$markup','$dateFormatted')";
$response = array();

// Perform the insertion into the first table
if ($con->query($sqlStocks) === TRUE) {
    // Get the generated ID from the first table insertion
    $generatedId = $con->insert_id;
    $state = 'in';
    // Insert data into the second table ("transactions") using the same ID
    $sqlTransactions = "INSERT INTO transactions (item_id, item_quantity, state, date) VALUES ('$generatedId', '$quantity', '$state', '$dateFormatted')";

    if ($con->query($sqlTransactions) === TRUE) {
        // Both insertions successful
        $response["status"] = "success";
        $response["message"] = "Data inserted into both tables successfully";
    } else {
        // Error occurred while inserting into the second table
        $response["status"] = "error";
        $response["message"] = "Error: Failed to insert data into the second table";
    }
} else {
    // Error occurred while inserting into the first table
    $response["status"] = "error";
    $response["message"] = "Error: Failed to insert data into the first table";
}

// Close database connection
$con->close();

// Return response to Flutter app
header('Content-Type: application/json');
echo json_encode($response);
?>
