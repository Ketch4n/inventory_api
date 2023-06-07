<?php
// Connect to your database or perform any necessary setup
include 'db.php';
// Assuming you have a database table named 'products' with columns 'name' and 'price'
$query = "SELECT * FROM stocks ";
$result = mysqli_query($con, $query);

$products = array();
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Return the list of products as JSON
header('Content-Type: application/json');
echo json_encode($products);
?>
