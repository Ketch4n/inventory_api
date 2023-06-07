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
    // Successfully Login Message.
    $onLoginSuccess = 'Login Matched';

    // Access other columns like 'name'
	$id = $row['id'];
    $name = $row['name'];
	$username = $row['username'];
	$email_ad = $row['email'];
	$pos = $row['position'];



    // Create an associative array with the response data.
    $response = array(
        'message' => $onLoginSuccess,
		'id' => $id,
		'username' => $username,
        'name' => $name,
		'email_ad' => $email_ad,
		'pos' => $pos
	
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
