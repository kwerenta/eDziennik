<?php
require "../db.php";
$conn = connectToDB();

$rank = isset($_POST['class']) ? "students" : "teachers";
$sql = "SELECT `id` FROM {$rank} WHERE `id`={$_POST['typeid']} AND `user_id`={$_POST['id']} AND `class`='{$_POST['class']}'";
$exist = mysqli_query($conn, $sql);

if ($exist->num_rows !== 0) {
  $sql = "SELECT `isActivated` FROM users WHERE `id`={$_POST['id']} AND `email`='{$_POST['email']}' AND `isActivated`={$_POST['isActivated']}";
  $isActivated = mysqli_query($conn, $sql);

  if ($isActivated->num_rows !== 0) {
    $newValue = $_POST['isActivated'] === "0" ? 1 : 0;
    $sql = "UPDATE users SET `isActivated` = {$newValue} WHERE `id`={$_POST['id']} AND `email`='{$_POST['email']}'";
    mysqli_query($conn, $sql);
  }
}

header("Location: http://{$_SERVER['HTTP_HOST']}/admin/users.php");
