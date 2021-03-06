<?php
session_start();
require '../db.php';

$conn = connectToDB();

$sql = "SELECT * FROM users WHERE `email` = \"{$_POST['email']}\"";
$query = mysqli_query($conn, $sql);
$user = mysqli_fetch_array($query);

if ($user && password_verify($_POST['password'], $user['password'])) {
  $sql = "SELECT `rank` FROM ranks WHERE user_id = {$user['id']}";
  $query = mysqli_query($conn, $sql);
  $rank = mysqli_fetch_array($query);

  if (!isset($rank[0])) $rank = "student";
  elseif ($rank[0] == "1") $rank = "admin";
  elseif ($rank[0] == "2") $rank = "teacher";

  $sql = "SELECT * FROM {$rank}s WHERE user_id = {$user['id']}";
  $query = mysqli_query($conn, $sql);
  if ($query) $data = mysqli_fetch_array($query);
  $data['rank'] = $rank;
  $_SESSION['user'] = $data;
  header("Location: http://{$_SERVER['HTTP_HOST']}/{$rank}");
} else {
  $_SESSION['signinErrors'] = 'Błędny login lub hasło!';

  header("Location: http://{$_SERVER['HTTP_HOST']}/");
}
