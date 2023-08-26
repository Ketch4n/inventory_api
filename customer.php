<?php
include 'db.php'; // Include your database connection

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch id and category values from the database
 $query = "SELECT * FROM customers";

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
