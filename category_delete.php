<?php
include 'db.php';

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$id = $_POST['id'];

// Delete the stock data
$sql_stock = "DELETE FROM category WHERE id = '$id'";


// Perform the stock deletion
if ($con->query($sql_stock) === TRUE) {
    echo "Category deleted successfully. ";
    
  
} else {
    echo "Error deleting category: " . $con->error;
}

$conn->close();
?>
