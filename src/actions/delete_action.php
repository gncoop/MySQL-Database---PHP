<?php

session_start();

// Read variables and create connection
$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");
$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Read values passed from form
$_SESSION['delete_id'] = $_POST['delete_id'];
$delete_id = $_SESSION['delete_id'];

// Delete the task from databse using values
$delete = $conn->prepare("DELETE FROM task WHERE id = ? ");
$delete->bind_param("i", $delete_id);
$delete->execute();
$delete->close();

// Redirect back to index.php if the delete succeeds
header("Location: /index.php?");

?>