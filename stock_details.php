<?php
// Include your database connection configuration
include 'db.php';

// Check if stock_id parameter is provided in the request
if (isset($_GET['id'])) {
    $sid = $_GET['id'];

    // Prepare the query to fetch transactions for the given stock_id
       $query = "SELECT stocks.*,
          SUM(CASE WHEN transactions.state = 'in' THEN transactions.quantity ELSE 0 END) AS total_in_quantity,
          SUM(CASE WHEN transactions.state = 'out' THEN transactions.quantity ELSE 0 END) AS total_out_quantity,
          SUM(CASE WHEN transactions.state = 'in' THEN transactions.quantity ELSE -transactions.quantity END) AS total_quantity,
          (SELECT MAX(date) FROM transactions WHERE transactions.stock_id = stocks.id) AS date
          FROM stocks
          LEFT JOIN transactions ON stocks.id = transactions.stock_id
          WHERE stocks.id = '$sid'  -- Add this WHERE clause to filter by stock_id
          GROUP BY stocks.id ORDER BY date DESC";

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
