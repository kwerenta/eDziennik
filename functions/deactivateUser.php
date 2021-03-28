<?php
session_start();
if (!isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "admin") {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}
require "../db.php";
$conn = connectToDB();

$sql = sprintf(
  "SELECT `isActivated` FROM users WHERE `id`=%s AND `email`='%s' AND `isActivated`=%s",
  mysqli_real_escape_string($conn, $_POST['id']),
  mysqli_real_escape_string($conn, $_POST['email']),
  mysqli_real_escape_string($conn, $_POST['isActivated']),
);
$isActivated = mysqli_query($conn, $sql);

if ($isActivated->num_rows !== 0) {
  $newValue = $_POST['isActivated'] === "0" ? 1 : 0;
  $sql = "UPDATE users SET `isActivated` = {$newValue} WHERE `id`={$_POST['id']} AND `email`='{$_POST['email']}'";
  mysqli_query($conn, $sql);
}

header("Location: http://{$_SERVER['HTTP_HOST']}/admin/users.php");
