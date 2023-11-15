<?php

$DBhost = "127.0.0.1";
$DBuser = "root";
$DBpassword = "";
$DBname = "muhae";	
$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);	
if ($conn->connect_error) {	
    die("Connection failed: " . $conn->connect_error);	
    }
    
?>
