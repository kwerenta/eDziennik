<?php
session_start();

if (!isset($_SESSION["user"])) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

require 'validate.php';

if (!isEmpty('email') && isLenghtCorrect($_POST['newPassword'], 8, 32)) {
  require "../db.php";
  $conn = connectToDB();

  $sql = "SELECT `password` FROM users WHERE `email`='{$_SESSION['user']['email']}' AND `id`={$_SESSION['user']['user_id']}";
  $query = mysqli_query($conn, $sql);
  $dbPassword = mysqli_fetch_array($query, MYSQLI_NUM)[0];

  if (password_verify($_POST['currentPassword'], $dbPassword)) {
    $hash = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
    $sql = sprintf(
      "UPDATE users SET `password` = '%s' WHERE `email`='%s' AND `id`=%s",
      $hash,
      $_SESSION['user']['email'],
      $_SESSION['user']['user_id']
    );
    mysqli_query($conn, $sql);
    if (mysqli_affected_rows($conn) > 0) {
      $_SESSION['snackalert'] = ["type" => "success", "text" => "Hasło zostało zmienione!"];
    } else {
      $_SESSION['snackalert'] = ["type" => "error", "text" => "Nie udało się zmienić hasła!"];
    }
  } else {
    $_SESSION['snackalert'] = ["type" => "error", "text" => "Błędne hasło!"];
  }
} else {
  $_SESSION['snackalert'] = ["type" => "error", "text" => "Formularz został błędnie wypełniony!"];
}

header("Location: http://{$_SERVER['HTTP_HOST']}/{$_SESSION['user']['rank']}/settings.php");
