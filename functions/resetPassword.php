<?php
session_start();
require "../db.php";
$conn = connectToDB();

$isEmpty = false;
$isEmailCorrect = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

foreach ($_POST as $input => $value) {
  if ($value === null) {
    $isEmpty = true;
  }
}

if (!$isEmpty && $isEmailCorrect) {
  $binary = openssl_random_pseudo_bytes(4, $isStrong);
  if ($isStrong) {
    $hex = bin2hex($binary);
    $hash = password_hash($hex, PASSWORD_BCRYPT);

    $sql = "SELECT `id` FROM users WHERE `email`='{$_POST['email']}'";
    $query = mysqli_query($conn, $sql);
    if ($query->num_rows === 0) {
      $_SESSION['formErrors'] = "Nie istnieje taki użytkownik";
      header("Location: http://{$_SERVER['HTTP_HOST']}/");
      exit();
    };

    $id = mysqli_fetch_array($query);
    $sql = "SELECT `rank` FROM ranks WHERE `user_id` = {$id['id']}";
    $query = mysqli_query($conn, $sql);
    $rank = mysqli_fetch_array($query);

    $rank = isset($rank) ? ($rank === "1" ? "admins" : "teachers") : "students";
    $sql = "SELECT `first_name`, `last_name` FROM {$rank} WHERE `first_name`='{$_POST['firstName']}' AND `last_name`='{$_POST['lastName']}'";
    $query = mysqli_query($conn, $sql);

    if ($query->num_rows === 0) {
      $_SESSION['formErrors'] = "Nie istnieje taki użytkownik";
      header("Location: http://{$_SERVER['HTTP_HOST']}/");
      exit();
    };

    $sql = "UPDATE users SET `password` = '{$hash}' WHERE `email`='{$_POST['email']}'";
    $isChanged = mysqli_query($conn, $sql);
    if ($isChanged) {
      $_SESSION['formErrors'] = "Twoje nowe hasło to: {$hex}";
    } else {
      $_SESSION['formErrors'] = "Nie udało się zmienić hasła!";
    }
  } else {
    $_SESSION['formErrors'] = "Wstąpił błąd! Spróbuj ponownie";
  }
} else {
  $_SESSION['formErrors'] = "Niepoprawnie wypełniony formularz";
}

header("Location: http://{$_SERVER['HTTP_HOST']}/");
