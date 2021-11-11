<?php
// echo "<hr></hr>";
// echo "SESSION VARIABLES <br>";
// var_dump($_SESSION);
// echo "<hr></hr>";

$errors = array (
    1 => "Error: Your passwords do not match.",
    2 => "Error: Username already exists.",
    3 => "Error: User does not exist.",
    4 => "Error: Incorrect password.",
    5 => "Please log in.",
    6 => "You have been logged out."
);
$error_id = isset($_GET['err']) ? (int)$_GET['err'] : 0;
if ($error_id != 0 && array_key_exists($error_id, $errors)) {
    echo $errors[$error_id];
}

?>

<!DOCTYPE HTML>
<html>  
<body>
<h1>Login</h1>
<form action="/actions/login_action.php" method="POST">
Username: <input type="text" name="username" required><br>
Password: <input type="password" name="password" required><br><br>
<button type="submit" id="login_button">Log In</button>
</body>
</html>