<?php

include '../db/database.php';

header('Content-Type: application/json'); // Set response content type to JSON

if ($con->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $con->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize input (you should use prepared statements for better security)
    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);

    // Fetch user data based on the provided username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $con->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password']; // Assuming the password is stored as plain text in the database

        // Verify the password
        if ($password === $storedPassword) {
            // Construct a success response with user ID
            $response = [
                'success' => true,
                'id' => $row['id'], // Include other user-related data if needed
            ];
            echo json_encode($response);
        } else {
            // Construct a failure response with an error message
            $response = [
                'success' => false,
                'message' => 'Invalid password',
            ];
            echo json_encode($response);
        }
    } else {
        // Construct a failure response with an error message
        $response = [
            'success' => false,
            'message' => 'User not found',
        ];
        echo json_encode($response);
    }
} else {
    // Construct a failure response for an invalid request method
    $response = [
        'success' => false,
        'message' => 'Invalid request method',
    ];
    echo json_encode($response);
}

$con->close();
?>
