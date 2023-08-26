<?php
// Include your database connection configuration
include 'db.php';

// Check if stock_id parameter is provided in the request
if (isset($_GET['stock_id'])) {
    $stock_id = $_GET['stock_id'];

    // Prepare the query to fetch transactions for the given stock_id
    $query = "SELECT * FROM transactions WHERE stock_id = $stock_id ORDER BY date DESC";

    $result = $con->query($query);

    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo json_encode(array());
    }
} else {
    echo json_encode(array());
}

$con->close();
?>
