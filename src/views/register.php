<?php
$errors = array (
    1 => "Error: Your passwords do not match.",
    2 => "Error: Username already exists."
);
$error_id = isset($_GET['err']) ? (int)$_GET['err'] : 0;
if ($error_id != 0 && array_key_exists($error_id, $errors)) {
    echo $errors[$error_id];
}

?>

<!DOCTYPE HTML>
<html>  
<head>
<body>
<h1>Register</h1>
<form action="/actions/register_action.php" method="POST">
Enter username: <input type="text" name="username" required><br>
Enter password: <input type="password" name="pass1" required><br>
Confirm password: <input type="password" name="pass2" required><br><br>
<button type="submit">Register</button>
</form>

</body>
</html>
