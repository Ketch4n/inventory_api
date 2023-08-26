<?php

// Include your database connection configuration
include 'db.php';

// Check if stock_id parameter is provided in the request
if (isset($_GET['id'])) {
    $sid = $_GET['id'];

    // Prepare the query to fetch transactions
    $query = "";
    if ($sid == 0) {
        // Fetch all rows when id is 0
        $query = "SELECT stocks.*,
                  (SELECT SUM(CASE WHEN transactions.state = 'in' THEN transactions.quantity ELSE 0 END) FROM transactions WHERE transactions.stock_id = stocks.id) AS total_in_quantity,
                  (SELECT SUM(CASE WHEN transactions.state = 'out' THEN transactions.quantity ELSE 0 END) FROM transactions WHERE transactions.stock_id = stocks.id) AS total_out_quantity,
                  (SELECT COALESCE(SUM(CASE WHEN transactions.state = 'in' THEN transactions.quantity ELSE -transactions.quantity END), 0) FROM transactions WHERE transactions.stock_id = stocks.id) AS total_quantity,
                  (SELECT MAX(date) FROM transactions WHERE transactions.stock_id = stocks.id) AS date
                  FROM stocks
                  ORDER BY date DESC";
    } else {
        // Fetch details for the given stock_id
        $query = "SELECT stocks.*,
                  (SELECT SUM(CASE WHEN transactions.state = 'in' THEN transactions.quantity ELSE 0 END) FROM transactions WHERE transactions.stock_id = stocks.id) AS total_in_quantity,
                  (SELECT SUM(CASE WHEN transactions.state = 'out' THEN transactions.quantity ELSE 0 END) FROM transactions WHERE transactions.stock_id = stocks.id) AS total_out_quantity,
                  (SELECT COALESCE(SUM(CASE WHEN transactions.state = 'in' THEN transactions.quantity ELSE -transactions.quantity END), 0) FROM transactions WHERE transactions.stock_id = stocks.id) AS total_quantity,
                  (SELECT MAX(date) FROM transactions WHERE transactions.stock_id = stocks.id) AS date
                  FROM stocks
                  WHERE stocks.id = '$sid'
                  GROUP BY stocks.id ORDER BY date DESC";
    }

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
