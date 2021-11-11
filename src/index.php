<?php

// error_reporting(-1);

session_start();

$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");

$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Print to the browser
// echo "<hr></hr>";
// echo "SESSION VARIABLES <br>";
// var_dump($_SESSION);
// echo "<hr></hr>";
// echo "<p>Feel free to overwrite this file.</p>";

if ($_SESSION["logged_in"] == NULL){
    header("Location: /views/login.php?err=5");
    exit;
}

$errors = array (
  1 => "Task created successfully.",
);
$error_id = isset($_GET['err']) ? (int)$_GET['err'] : 0;
if ($error_id != 0 && array_key_exists($error_id, $errors)) {
  echo $errors[$error_id];
}

// Find tasks for user
$user_id = $_SESSION['user_id'];

$sql = "SELECT `id`, `text`, `date`, `done` FROM `task` WHERE `user_id` = ? ORDER BY `date` ";

$find = $conn->prepare($sql);
$find->bind_param("s", $user_id);
$find->execute();

// convert to a result
$result = $find->get_result();

// while ($row = $result->fetch_assoc()) {
//   echo "Description = $row[text], Date = $row[date], and Done = $row[done] <br>";
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Add an appropriate title in this tag -->
  <title>IT&C Task List</title>
  <!-- Links to stylesheets -->
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- Your visible elements -->
  <nav class="dark">
    <a href="https://learningsuite.byu.edu/.lhUR/student/top">LearningSuite</a>
    <form action ="/actions/logout_action.php" method="POST">
    <button type="submit" class="logout">Log Out</button>
    </form>
  </nav>
  <h1>IT&C 210 Task List</h1>
  <form>
    <input type='checkbox' class="toggle-switch" id="cb-sort"/><label for="cb-sort">Sort by date</label>
    <input type='checkbox' class="toggle-switch" id="cb-filter"/><label for="cb-filter">Filter completed tasks</label>
  </form>
    <ul class="tasklist">
      <?php
      while ($row = $result->fetch_assoc()) {
        ?>
        <li class="task">
        <form action="/actions/update_action.php" method="POST" class="data">
        <input type="hidden" name="id" value="<?php echo "$row[id]" ?>">
        <input type="hidden" name="done" value="<?php echo "$row[done]" ?>">
        <button type="submit" class="task-done material-icon"> 
          
        <?php
        if ($row["done"] == 0) {
          echo "check_box_outline_blank";
        } else {
          echo "check_box";
        }
        ?>
        
        </button></form>
        <span class="task-description strikethrough"> <?php echo "$row[text]" ?></span>
        <span class="task-date"> <?php echo "$row[date]" ?></span>

        <form action="/actions/delete_action.php" method="POST" class="data">
        <input type="hidden" name="delete_id" value="<?php echo "$row[id]" ?>">
        <button type="submit" class="task-delete material-icon">highlight_off
        </button></form>
        </li>
        <?php
      }
      ?>
    <form class="form-create-task" action="/actions/create_action.php" method="POST">
      <br>
      <input type="text" class="custom-description" id="description_input" name="text_input" required><br>
      <input type="date" id="date_input" name="date_input" required><br><br>
      <button type="submit" class="custom-button">Create Task</button>
    </form>
  </ul>
  <!-- Links to scripts -->
  <script src="js/script.js"></script>
</body>
</html>


<!-- <form class="form-create-task" onsubmit="on_submit(event)"> -->