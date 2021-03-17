<?php
session_start();
require '../db.php';

$conn = connectToDB();
$isEmpty = false;
$isLastInputCorrect = false;
$isPasswordConfirmed = false;
$isEmailCorrect = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$isTypeCorrect = in_array($_POST['type'], array('student', 'teacher'));

foreach ($_POST as $input => $value) {
  if ($value === null) {
    $isEmpty = true;
  }
}

if ($isTypeCorrect && $_POST['type'] === 'student') {
  $letters = ['A', 'B', 'C', 'D'];
  $numbers = ['1', '2', '3', '4'];
  foreach ($numbers as $number) {
    foreach ($letters as $letter) {
      $class = $number . $letter;
      if (isset($_POST['class']) && $_POST['class'] === $class) {
        $isClassCorrect = true;
        break 2;
      }
    }
  }
} else {
  $isLastInputCorrect = true;
}

if (!$isEmpty && $isLastInputCorrect && $isEmailCorrect && $isTypeCorrect) {

  $sql = "SELECT `email` FROM users WHERE `email`='{$_POST['email']}'";
  $emailExist = mysqli_query($conn, $sql);

  if ($emailExist->num_rows !== 0) {
    $_SESSION['formErrors'] = "Podany E-Mail jest już zajęty!";
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
      "{$_POST['{$lastField}']}");
    SQL;
    $newData = mysqli_query($conn, $sql);
    if ($newData && $_POST['type'] === "teacher") {
      $sql = "INSERT INTO ranks VALUES ({$id},2)";
      mysqli_query($conn, $sql);
    }
  }
} else {
  $_SESSION['formErrors'] = "Formularz został błędnie wypełniony!";
}
header("Location: http://{$_SERVER['HTTP_HOST']}/");
