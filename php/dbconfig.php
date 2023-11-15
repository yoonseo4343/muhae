<?php

$DBhost = "localhost";
$DBuser = "root";
$DBpassword = "XXXXX";
$DBname = "testDB";	
$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);	
if ($conn->connect_error) {	
    die("Connection failed: " . $conn->connect_error);	
    }
    
?>
