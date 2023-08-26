<?php
include 'db.php';

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$id = $_POST['id'];

// Delete the stock data
$sql_stock = "DELETE FROM stocks WHERE id = '$id'";

// Delete the transaction data
$sql_transaction = "DELETE FROM transactions WHERE stock_id = '$id'";

// Perform the stock deletion
if ($con->query($sql_stock) === TRUE) {
    echo "Stock deleted successfully. ";
    
    // Perform the transaction deletion
    if ($con->query($sql_transaction) === TRUE) {
        echo "Associated transactions also deleted.";
    } else {
        echo "Error deleting associated transactions: " . $con->error;
    }
} else {
    echo "Error deleting stock: " . $con->error;
}

$conn->close();
?>
