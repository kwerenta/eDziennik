<?php

session_start();

require 'db.php';

$conn = connectToDB();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $sql = "SELECT * FROM users WHERE email = \"{$_POST['email']}\"";
  $query = mysqli_query($conn, $sql);
  $user = mysqli_fetch_array($query);
  if ($_POST['email'] !== $user['email'] || md5($_POST['password']) !== $user['password']) {
    $error = 'Błędny login lub hasło!';
  } else {
    $sql = "SELECT `rank` FROM ranks WHERE user_id = {$user['id']}";
    $query = mysqli_query($conn, $sql);
    $rank = mysqli_fetch_array($query);
    switch ($rank) {
      case 1:
        $rank = "admin";
        break;
      case 2:
        $rank = "teacher";
        break;
      default:
        $rank = "student";
        break;
    }

    $sql = "SELECT * FROM {$rank}s WHERE user_id = {$user['id']}";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);
    $_SESSION['user'] = $data;
    header("Location: /{$rank}");
  }
}

require 'render.php';
$header = new View('header');
$header->allocate('styles', ['global', 'forms']);
$header->render();
$forms = new View("forms");
$forms->render();
$footer = new View('footer');
