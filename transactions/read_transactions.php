<?php
include '../db/database.php'; // Include your database connection
header('Content-Type: application/json');

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$id = $_POST['item_id'];

// Prepare and execute the query with a JOIN operation
$query = "SELECT transactions.*, orders.* 
          FROM transactions 
          JOIN orders ON transactions.item_id = orders.item_id 
          WHERE transactions.item_id = '$id' 
          ORDER BY transactions.date DESC";

$result = $con->query($query);

if (!$result) {
    die("Query failed: " . $con->error);
}

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    echo json_encode($data);
} else {
    echo json_encode(array());
}

$con->close();
?>
