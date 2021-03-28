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

  $rank = isset($_POST['class']) ? "students" : "teachers";
  $lastField = isset($_POST['class']) ? "`class`='{$_POST['class']}'" : "`phone`='{$_POST['phone']}'";

  $sql = sprintf(
    "UPDATE %s SET `first_name` = '%s', `last_name`= '%s', %s WHERE `id`=%s AND `user_id`=%s",
    $rank,
    mysqli_real_escape_string($conn, $_POST['first_name']),
    mysqli_real_escape_string($conn, $_POST['last_name']),
    $lastField,
    mysqli_real_escape_string($conn, $_POST['typeid']),
    mysqli_real_escape_string($conn, $_POST['id']),
  );
  mysqli_query($conn, $sql);
}

header("Location: http://{$_SERVER['HTTP_HOST']}/admin/users.php");
