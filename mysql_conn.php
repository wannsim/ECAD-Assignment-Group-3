<?php
//Connection Parameters
$servername = 'localhost:3308';
$username = 'root';
$userpwd = '';
$dbname = 'ecad_asg1'; 

// Create connection
$conn = new mysqli($servername, $username, $userpwd, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);	
}
?>
