<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "admin")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

$isEmpty = false;

foreach ($_POST as $input => $value) {
  if ($value === null) {
    $isEmpty = true;
  }
}
if (!$isEmpty) {
  require "../db.php";
  $conn = connectToDB();

  $sql = "SELECT `id` FROM users WHERE `id`={$_POST['id']} AND `email`='{$_POST['email']}'";
  $exist = mysqli_query($conn, $sql);

  $rank = isset($_POST['class']) ? "students" : "teachers";
  $lastField = isset($_POST['class']) ? "`class`='{$_POST['class']}'" : "`phone`='{$_POST['phone']}'";

  if ($exist->num_rows !== 0) {
    $sql = "UPDATE {$rank} SET `first_name` = '{$_POST['first_name']}', `last_name`= '{$_POST['last_name']}', {$lastField} WHERE `id`={$_POST['typeid']} AND `user_id`={$_POST['id']}";
    mysqli_query($conn, $sql);
  }
}

header("Location: http://{$_SERVER['HTTP_HOST']}/admin/users.php");
