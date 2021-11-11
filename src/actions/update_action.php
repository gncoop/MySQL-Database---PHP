<?php
session_start();

// Read variables and create connection
$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");
$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Read value passed from form
$_SESSION['task_id'] = $_POST['id'];
$_SESSION['task_done'] = $_POST['done'];
$task_id = $_SESSION['task_id'];
$task_done = $_SESSION['task_done'];

// echo ("Task id:  $task_id");
// echo ("Task idone:  $task_done");

// Update the task in the database
if ($task_done == 1) {
    $update = $conn->prepare("UPDATE task SET done = 0 WHERE id = ? ");
    $update->bind_param("i", $task_id);
    $update->execute();
    $update->close();
} else {
    $update = $conn->prepare("UPDATE task SET done = 1 WHERE id = ? ");
    $update->bind_param("i", $task_id);
    $update->execute();
    $update->close();
}

// Redirect back to index.php if the update succeeds
header("Location: /index.php?");

?>