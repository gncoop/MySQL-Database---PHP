<?php
// ./actions/login_action.php

session_start();

$_SESSION['username'] = $_POST['username'];
$_SESSION['password'] = $_POST['password'];

// Read variables and create connection
$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");

// This section for DEBUGGING ONLY! COMMENT-OUT WHEN FINISHED
// echo "<p>mysql_servername: $mysql_servername</p>";
// echo "<p>mysql_user: $mysql_user</p>";
// echo "<p>mysql_password: $mysql_password</p>";
// echo "<p>mysql_database: $mysql_database</p>";

$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// // Check connection
// if ($conn->connect_error) {
// 	die("Connection failed: " . $conn->connect_error);
// } else {
// 	echo "Database Connection Success";
// }

// TODO: Log the user in

$user = $conn->real_escape_string($_POST['username']);
$pass = $conn->real_escape_string($_POST['password']);

$check = $conn->prepare("SELECT `username` FROM `user` WHERE `username` = ? ");
$check->bind_param("s", $user);
$check->execute();
// $check->bind_result($username);
if($check->fetch() > 0) {
	$check->close();
	// echo ("Checking if passwords match");

	$compare = $conn->prepare('SELECT `password` FROM `user` WHERE `username` = ? ');
	if ($compare) {
		$compare->bind_param("s", $user);
		$compare->execute();
		$compare->bind_result($hash);

		if ($compare->fetch() > 0) {
			$compare->close();
			// echo nl2br("\n");
			// echo ("There is a password for user");
			// compare with hash using password_verify
			if (password_verify($pass, $hash)) {
				// echo nl2br("\n");
				// echo ("Password's match");
				// echo nl2br("\n");

				// Setting logged_in to true
				$login = $conn->prepare("UPDATE user SET logged_in = 1 WHERE username = ? ");
				$login->bind_param("s", $user);
				$login->execute();
				$login->close();
				
				// Setting session variables
				$get_id = $conn->prepare('SELECT `id` FROM `user` WHERE `username` = ? ');
				$get_id->bind_param("s", $user);
				$get_id->execute();
				$get_id->bind_result($id);
				$get_id->fetch();
				$_SESSION["logged_in"] = "yes";
				$_SESSION["username"] = "$user";
				$_SESSION["user_id"] = "$id";

				// Redirect to application
				header("Location: /index.php");
			} else {
				// echo nl2br("\n");
				// echo ("Password's don't match");
				header("Location: /views/login.php?err=4");
			}
		} else {

			echo nl2br("\n");
			echo ("There is no password for user");
		}
	} else {
		echo $compare->error;
		echo $conn->error;
		die('We died');
	}

} else {
    header("Location: /views/login.php?err=3");
    exit;
}

?>