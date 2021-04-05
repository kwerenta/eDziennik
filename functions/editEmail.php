<?php
session_start();

if (!isset($_SESSION["user"])) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

require 'validate.php';

if (!isEmpty() && isEmailCorrect()) {
  require "../db.php";
  $conn = connectToDB();

  $sql = sprintf(
    "UPDATE users SET `email` = '%s' WHERE `email`='%s' AND `id`=%s",
    mysqli_escape_string($conn, $_POST['email']),
    $_SESSION['user']['email'],
    $_SESSION['user']['user_id']
  );
  mysqli_query($conn, $sql);
  if (mysqli_affected_rows($conn) > 0) {
    $_SESSION['user']['email'] = $_POST['email'];
    $_SESSION['snackalert'] = ["type" => "success", "text" => "E-Mail został zmieniony!"];
  } else {
    $_SESSION['snackalert'] = ["type" => "error", "text" => "Nie udało się zmienić E-Maila!"];
  }
} else {
  $_SESSION['snackalert'] = ["type" => "error", "text" => "Formularz został błędnie wypełniony!"];
}

header("Location: http://{$_SERVER['HTTP_HOST']}/{$_SESSION['user']['rank']}/settings.php");
