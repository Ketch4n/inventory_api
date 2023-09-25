<?php
include '../db/database.php';

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get data from Flutter app
$data = json_decode(file_get_contents('php://input'), true);

// Extract the date from the data
$item_id = $data['item_id'];
$item_name = $data['item_name'];
$customer_id = $data['customer_id'];
$customer_name = $data['customer_name'];
$customer_store = $data['customer_store'];
$customer_location = $data['customer_location'];
$price = $data['price'];
$markup = $data['markup'];
$retail = $data['retail'];
$quantity = $data['quantity'];
$payment = $data['payment'];
$date = $data['date'];
$dateFormatted = date('Y-m-d H:i:s', strtotime($date));

// Insert data into the first table ("orders") using prepared statements
$sqlStocks = "INSERT INTO orders (item_id, item_name, customer_id, customer_name, customer_store, customer_location, price, markup, retail, order_quantity, payment, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$response = array();

$stmt = $con->prepare($sqlStocks);

if ($stmt) {
    // Bind parameters
    $stmt->bind_param("ssssssssssss", $item_id, $item_name, $customer_id, $customer_name, $customer_store, $customer_location, $price, $markup, $retail, $quantity, $payment, $dateFormatted);

    // Execute the statement
    if ($stmt->execute()) {
        // Get the generated ID from the first table insertion
        $state = 'out';
        // Insert data into the second table ("transactions") using the same ID
        $sqlTransactions = "INSERT INTO transactions (item_id, item_quantity, state, date) VALUES (?, ?, ?, ?)";
        $stmtTransactions = $con->prepare($sqlTransactions);

        if ($stmtTransactions) {
            $stmtTransactions->bind_param("ssss", $item_id, $quantity, $state, $dateFormatted);

            if ($stmtTransactions->execute()) {
                // Both insertions successful
                $response["status"] = "success";
                $response["message"] = "Data inserted into both tables successfully";
            } else {
                // Error occurred while inserting into the second table
                $response["status"] = "error";
                $response["message"] = "Error: Failed to insert data into the second table";
            }
        } else {
            // Error occurred while preparing the second statement
            $response["status"] = "error";
            $response["message"] = "Error: Failed to prepare the second statement";
        }
    } else {
        // Error occurred while inserting into the first table
        $response["status"] = "error";
        $response["message"] = "Error: Failed to insert data into the first table";
    }
    $stmt->close();
} else {
    // Error occurred while preparing the first statement
    $response["status"] = "error";
    $response["message"] = "Error: Failed to prepare the first statement";
}

// Close database connection
$con->close();

// Return response to Flutter app
header('Content-Type: application/json');
echo json_encode($response);
?>
