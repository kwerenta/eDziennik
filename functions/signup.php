<?php
session_start();
require '../db.php';
require 'validate.php';

$conn = connectToDB();
$isLastInputCorrect = false;
$isTypeCorrect = in_array($_POST['type'], array('student', 'teacher'));

if ($isTypeCorrect) {
  if ($_POST['type'] === 'student') {
    $isLastInputCorrect = isClassCorrect();
  } else {
    $isLastInputCorrect = isPhoneCorrect();
  }
}
if (
  !isEmpty() &&
  isEmailCorrect() &&
  isLenghtCorrect($_POST["firstName"], 1, 100) &&
  isLenghtCorrect($_POST["lastName"], 1, 100) &&
  isLenghtCorrect($_POST['password'], 8, 32) &&
  $isLastInputCorrect &&
  $isTypeCorrect
) {

  $sql = sprintf(
    "SELECT `email` FROM users WHERE `email`='%s'",
    mysqli_real_escape_string($conn, $_POST['email'])
  );
  $emailExist = mysqli_query($conn, $sql);

  if ($emailExist->num_rows !== 0) {
    $_SESSION['formInfos']['error'] = "Podany E-Mail jest już zajęty!";
    header("Location: http://{$_SERVER['HTTP_HOST']}/");
    exit();
  }

  $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $sql = "INSERT INTO users(`email`,`password`) VALUES ('{$_POST['email']}','{$pass}')";
  $newUser = mysqli_query($conn, $sql);

  if ($newUser) {
    $id = mysqli_insert_id($conn);
    $lastField = $_POST['type'] === "student" ? "class" : "phone";
    $sql = <<<SQL
    INSERT INTO {$_POST['type']}s (`user_id`,`first_name`,`last_name`,`{$lastField}`) VALUES
      ("{$id}",
      "{$_POST['firstName']}",
      "{$_POST['lastName']}",
      "{$_POST[$lastField]}");
    SQL;
    $newData = mysqli_query($conn, $sql);
    if ($newData && $_POST['type'] === "teacher") {
      $sql = "INSERT INTO ranks VALUES ({$id},2)";
      mysqli_query($conn, $sql);
      $_SESSION['formInfos']['success'] = "Twoje konto zostało utworzone,<br>czekaj na aktywację!";
    }
  }
} else {
  $_SESSION['formInfos']['error'] = "Formularz został błędnie wypełniony!";
}
header("Location: http://{$_SERVER['HTTP_HOST']}/");
