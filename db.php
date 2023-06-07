<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");


 $HostName = "localhost";
 $DatabaseName = "inventory";
 $HostUser = "root";
 $HostPass = ""; 
 
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
?>