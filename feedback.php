<?php
	$mysqli = new mysqli('localhost', 'root', 'r', 'secure');
    //$mysqli = new mysqli('localhost', 'mreuser1_mits', 'mits@123','mreuser1_healthvault');
    if ($mysqli->connect_errno) {
        echo "Sorry, this website is experiencing problems.";
        echo "Error: Failed to make a MySQL connection, here is why: \n";
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
    }
    $response=$_GET['response'];
    $sql="insert into feedback values('test2','$response')";
    $result=mysqli_query($mysqli,$sql);
?>