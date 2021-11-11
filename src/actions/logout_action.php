<?php
// ./actions/logout_action.php

session_start();

// Read variables and create connection
$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");
$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} else {
	// echo "Database Connection Success";
}

$user = $conn->real_escape_string($_SESSION['username']);

// TODO: Log the user out

// Update logged_in variable in database
$logout = $conn->prepare("UPDATE user SET logged_in = 0 WHERE username = ? ");
$logout->bind_param("s", $user);
$logout->execute();
$logout->close();

// Delete session variables
session_destroy();

// Redirect to login.php
header("Location: /views/login.php?err=6");
exit;




?>

UPDATE user SET logged_in = '?' WHERE username = '?' 
INSERT INTO user (logged_in) VALES (?)