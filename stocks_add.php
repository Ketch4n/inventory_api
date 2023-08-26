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
$item = $data['item'];
$type = $data['type'];
$category = $data['category'];
$price = $data['price'];
$markup = $data['markup'];

$quantity = $data['quantity'];

// Convert the date to a valid SQL date format (assuming the date is in the format "yyyy-MM-dd HH:mm:ss")
$dateFormatted = date('Y-m-d H:i:s', strtotime($date));

// Insert data into the first table ("stocks")
$sqlStocks = "INSERT INTO stocks (item, type, category, price,markup,initial_qnt, date) VALUES ('$item', '$type', '$category', '$price','$markup','$quantity', '$dateFormatted')";

$response = array();

// Perform the insertion into the first table
if ($con->query($sqlStocks) === TRUE) {
    // Get the generated ID from the first table insertion
    $generatedId = $con->insert_id;
    $state = 'in';
    // Insert data into the second table ("transactions") using the same ID
    $sqlTransactions = "INSERT INTO transactions (stock_id, quantity, price,markup,state, date) VALUES ('$generatedId', '$quantity', '$price','$markup','$state', '$dateFormatted')";

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
