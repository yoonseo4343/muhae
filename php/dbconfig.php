<?php
// DB연결
$DBhost = "ysy-instance-rds.cjmgpc5vbjlx.us-east-1.rds.amazonaws.com";
$DBuser = "admin";
$DBpassword = "admin123";
$DBname = "muhae";	
$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);	
if ($conn->connect_error) {	
    die("Connection failed: " . $conn->connect_error);	
    }
    
?>
