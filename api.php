<?php
include 'db.php';

// Getting the received JSON into $json variable.
$json = file_get_contents('php://input');
// Decoding the received JSON and store into $obj variable.
$obj = json_decode($json, true);
// Getting User email from JSON $obj array and store into $email.
$email = $obj['username'];
// Getting Password from JSON $obj array and store into $password.
$password = $obj['password'];
// Applying User Login query with email and password.
$loginQuery = "SELECT * FROM users WHERE username = '$email' and password = '$password' ";

// Executing SQL Query.
$result = mysqli_query($con, $loginQuery);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $response = array(
        'message' => 'Login Matched',
		'id' => $row['id'],
        'username' => $row['username'],
        'name' => $row['name'],
        'email_ad' => $row['email'],
        'position' => $row['position']
    );
    // Converting the message into JSON format.
    $SuccessMSG = json_encode($response);

    // Echo the message.
    echo $SuccessMSG;
} else {
    // If Email and Password did not Matched.
    $InvalidMSG = 'Invalid Username or Password. Please Try Again';

    // Create an associative array with the response data.
    $response = array(
        'message' => $InvalidMSG
    );

    // Converting the message into JSON format.
    $InvalidMSGJson = json_encode($response);

    // Echo the message.
    echo $InvalidMSGJson;
}

mysqli_close($con);
?>
