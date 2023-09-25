<?php

// Include your database connection configuration
include '../db/database.php';
header('Content-Type: application/json');
// Prepare the query to fetch transactions for all stocks along with all stock data
$query = "SELECT stocks.*, 
          SUM(CASE WHEN transactions.state = 'in' THEN transactions.item_quantity ELSE 0 END) AS total_in_quantity,
          SUM(CASE WHEN transactions.state = 'out' THEN transactions.item_quantity ELSE 0 END) AS total_out_quantity,
          COALESCE(SUM(CASE WHEN transactions.state = 'in' THEN transactions.item_quantity ELSE -transactions.item_quantity END), 0) AS total_quantity,
          MAX(transactions.date) AS date
          FROM stocks
          LEFT JOIN transactions ON stocks.id = transactions.item_id
          GROUP BY stocks.id
          ORDER BY date DESC";

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

$con->close();

?>
