<?php
session_start();

$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");

$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
// if ($conn->connect_error) {
// 	die("Connection failed: " . $conn->connect_error);
// } else {
// 	echo "Database Connection Success";
// }

// Read files passed in from form 
$_SESSION['description'] = $_POST['text_input'];
$_SESSION['date'] = $_POST['date_input'];
$description = $_SESSION['description'];
$date = $_SESSION['date'];

// Grab id of current user from the session
$user_id = $_SESSION['user_id'];

// Create a new task in the database using form data and user's id
// var_dump($_SESSION);
$done_value = 0;
$create_task = $conn->prepare("INSERT INTO task (user_id, text, date, done) VALUES (?, ?, ?, ?)");
$create_task->bind_param("issi", $user_id, $description, $date, $done_value);
$create_task->execute();
$create_task->close();

// Redirect back to index.php on success
header("Location: /index.php");

?>