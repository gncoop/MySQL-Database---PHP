<?php
// ./actions/register_action.php

session_start();

$_SESSION['username'] = $_POST['username'];
$_SESSION['pass1'] = $_POST['pass1'];
$_SESSION['pass2'] = $_POST['pass2'];

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
// echo nl2br("\n\n");

// TODO: Verifying variables
// echo $_SESSION['username'];
// echo nl2br("\n");
// echo $_SESSION['pass1'];
// echo nl2br("\n");
// echo $_SESSION['pass2'];

if ($_SESSION['pass1'] == $_SESSION['pass2']) {
	// echo nl2br("\n");
	// echo ("Your passwords match!");
} else {
	header("Location: /views/register.php?err=1");
	// echo nl2br("\n");
	// echo ("They are NOT equal");
	exit;	
}

$user = $conn->real_escape_string($_POST['username']);
$pass = $conn->real_escape_string($_POST['pass1']);

$check = $conn->prepare("SELECT `username` FROM `user` WHERE `username` = ? ");
$check->bind_param("s", $user);
$check->execute();
// $check->bind_result($username);
if($check->fetch() > 0) {
    header("Location: /views/register.php?err=2");
    exit;
}
else {
	// echo nl2br("\n");
	// echo ("User does not exist");
	// echo nl2br("\n");
	$logged_in = 1;
	$pass = password_hash($pass, PASSWORD_DEFAULT);
	$insert = $conn->prepare("INSERT INTO user (username, password, logged_in) VALUES (?, ?, ?)");
	$insert->bind_param("ssi", $username, $password, $logged_in);
	$username = $user;
	$password = $pass;
	$insert->execute();

	$_SESSION["logged_in"] = "yes";
	header("Location: /index.php");

	
	// $sql = "INSERT INTO users (username, password, logged_in)
	// VALUES ('$user', '$pass', 'true')";

	// if ($conn->query($sql) === TRUE) {
  	// 	echo "New user created successfully";
	// } else {
  	// 	echo "Error: " . $sql . "<br>" . $conn->error;
	// }
};

// TODO: Register a new user

?>