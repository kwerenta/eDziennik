<?php

session_start();

if (isset($_SESSION["user"])) {
  header('Location: /' . $_SESSION['user']['rank']);
}

require 'db.php';

$conn = connectToDB();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $sql = "SELECT * FROM users WHERE email = \"{$_POST['email']}\"";
  $query = mysqli_query($conn, $sql);
  $user = mysqli_fetch_array($query);

  if (md5($_POST['password']) !== $user['password']) {
    $error = 'Błędny login lub hasło!';
  } else {
    $sql = "SELECT `rank` FROM ranks WHERE user_id = {$user['id']}";
    $query = mysqli_query($conn, $sql);
    $rank = mysqli_fetch_array($query);
    switch ($rank[0]) {
      case "1":
        $rank = "admin";
        break;
      case "2":
        $rank = "teacher";
        break;
      default:
        $rank = "student";
        break;
    }

    $sql = "SELECT * FROM {$rank}s WHERE user_id = {$user['id']}";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);
    $data['rank'] = $rank;
    $_SESSION['user'] = $data;
    header("Location: /{$rank}");
  }
}

require 'view.php';

$header = new View('header');
$header->allocate('styles', ['forms']);
$header->allocate('scripts', ['https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js', 'changeForm']);
$header->render();

$forms = new View("forms");
$forms->render();
