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
    $_SESSION['user'] = $user;
    switch ($user['rank']) {
      case 1:
        die('uczeń');
        break;
      case 2:
        die('nauczyciel');
        break;
      case 3:
        die('admin');
        break;

      default:
        die('Błąd! Niepoprawnie założone konto!');
        break;
    }
  }
}


include 'includes/header.php';
include 'includes/login.php';
include 'includes/footer.php';
