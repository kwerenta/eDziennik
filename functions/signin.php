<?php
session_start();
require '../db.php';
require 'validate.php';

$countryCode = "US";

$conn = connectToDB();

if (isEmailCorrect()) {
  $sql = sprintf(
    "SELECT * FROM users WHERE `email` = '%s'",
    mysqli_real_escape_string($conn, $_POST['email'])
  );
  $query = mysqli_query($conn, $sql);
  $user = mysqli_fetch_array($query);
}
if (isset($user) && password_verify($_POST['password'], $user['password'])) {
  if ($user['isActivated'] === "0") {
    $_SESSION['formInfos']['error'] = 'Your account is deactivated!';
    header("Location: http://{$_SERVER['HTTP_HOST']}/");
    exit();
  }
  $sql = "SELECT `rank` FROM ranks WHERE `user_id` = {$user['id']}";
  $query = mysqli_query($conn, $sql);
  $rank = mysqli_fetch_array($query);

  $rank = (!isset($rank[0])) ? "student" : ($rank[0] == "1" ? "admin" : "teacher");

  $sql = "SELECT * FROM {$rank}s WHERE `user_id` = {$user['id']}";
  $query = mysqli_query($conn, $sql);
  if (mysqli_num_rows($query)) {
    $data = mysqli_fetch_array($query);
    $data['rank'] = $rank;
    $data['email'] = $user['email'];
    if (isset($data['id'])) $data['id'] = intval($data['id']);
    $_SESSION['user'] = $data;

    if ($rank === "student") {
      $sql = "SELECT `id`,`first_name`,`last_name` FROM teachers";
      $query = mysqli_query($conn, $sql);
      while (($row = mysqli_fetch_array($query)) !== null) {
        $_SESSION['teachers'][$row['id']] = $row;
      }
    }

    if ($rank !== "admin") {
      $sql = "SELECT * FROM subjects ORDER BY `name`";
      $query = mysqli_query($conn, $sql);
      while (($row = mysqli_fetch_array($query)) !== null) {
        $_SESSION['subjects'][$row['id']] = $row;
      }

      $sql = "SELECT * FROM categories ORDER BY `weight`, `name`";
      $query = mysqli_query($conn, $sql);
      while (($row = mysqli_fetch_array($query)) !== null) {
        $_SESSION['categories'][$row['id']] = $row;
      }

      $holidays = file_get_contents("https://date.nager.at/Api/v2/NextPublicHolidays/{$countryCode}");
      $_SESSION['holiday'] = json_decode($holidays, true)[0];
    }
  }
} else {
  $_SESSION['formInfos']['error'] = 'Incorrect e-mail or password!';
}
header("Location: http://{$_SERVER['HTTP_HOST']}/");
