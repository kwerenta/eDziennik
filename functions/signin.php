<?php
session_start();
require '../db.php';

$conn = connectToDB();

$sql = "SELECT * FROM users WHERE `email` = \"{$_POST['email']}\"";
$query = mysqli_query($conn, $sql);
$user = mysqli_fetch_array($query);

if ($user && password_verify($_POST['password'], $user['password'])) {
  if ($user['isActivated'] === "0") {
    $_SESSION['formErrors'] = 'Twoje konto nie jest aktywne!';
    header("Location: http://{$_SERVER['HTTP_HOST']}/");
    exit();
  }
  $sql = "SELECT `rank` FROM ranks WHERE user_id = {$user['id']}";
  $query = mysqli_query($conn, $sql);
  $rank = mysqli_fetch_array($query);

  $rank = (!isset($rank[0])) ? "student" : ($rank[0] == "1" ? "admin" : "teacher");

  $sql = "SELECT * FROM {$rank}s WHERE user_id = {$user['id']}";
  $query = mysqli_query($conn, $sql);
  if ($query) {
    $data = mysqli_fetch_array($query);
    $data['rank'] = $rank;
    if (isset($data['id'])) $data['id'] = intval($data['id']);
    $_SESSION['user'] = $data;

    $sql = "SELECT * FROM subjects";
    $query = mysqli_query($conn, $sql);
    while (($row = mysqli_fetch_array($query)) !== null) {
      $_SESSION['subjects'][] = $row;
    }

    $sql = "SELECT `name`,`weight` FROM categories";
    $query = mysqli_query($conn, $sql);
    while (($row = mysqli_fetch_array($query)) !== null) {
      $_SESSION['categories'][] = $row;
    }

    $sql = "SELECT `id`,`first_name`,`last_name` FROM teachers";
    $query = mysqli_query($conn, $sql);
    while (($row = mysqli_fetch_array($query)) !== null) {
      $_SESSION['teachers'][] = $row;
    }
  }
} else {
  $_SESSION['formErrors'] = 'Błędny login lub hasło!';
}
header("Location: http://{$_SERVER['HTTP_HOST']}/");
