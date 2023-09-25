<?php
include '../db/database.php';
// Assuming you have a database connection established

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the stock data from the request body
    $id = $_POST['id'];
    $item = $_POST['item'];
    $type = $_POST['type'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $markup = $_POST['markup'];


    $date = $_POST['date'];
    $dateFormatted = date('Y-m-d H:i:s', strtotime($date));
    // Update the stock data in the database
    $sql = "UPDATE stocks SET item = ?, type = ?, category = ?, price = ?, markup = ?,  date = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssssi", $item, $type, $category, $price, $markup, $dateFormatted, $id);
    
    if ($stmt->execute()) {
        // Stock data updated successfully
        $response = array('status' => 'success', 'message' => 'Stock data updated successfully');
        echo json_encode($response);
    } else {
        // Error updating stock data
        $response = array('status' => 'error', 'message' => 'Error updating stock data');
        echo json_encode($response);
    }
} else {
    // Invalid request method
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    echo json_encode($response);
}
header('Content-Type: application/json');
// Close the database connection
$con->close();

?>
