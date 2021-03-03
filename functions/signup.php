<?php
require '../db.php';

$conn = connectToDB();
$isEmpty = false;

foreach ($_POST as $input => $value) {
  if ($value === null) {
    $isEmpty = true;
  }
}

if (!$isEmpty) {
  $sql = "SELECT `email` FROM users WHERE `email`='{$_POST['email']}'";
  $emailExist = mysqli_query($conn, $sql);

  // mysqli_prepare();
  // mysqli_stmt_bind_param();

  if ($emailExist) {
    header("Location: http://{$_SERVER['HTTP_HOST']}/index.php");
  }

  $pass = md5($_POST['password']);
  $sql = "INSERT INTO users(`email`,`password`) VALUES ('{$_POST['email']}','{$pass}')";
  $newUser = mysqli_query($conn, $sql);

  if ($newUser) {
    $id = mysqli_insert_id($conn);
    $sql = <<<SQL
  INSERT INTO students (`user_id`,`first_name`,`last_name`,`class`) VALUES
    ("{$id}",
    "{$_POST['firstName']}",
    "{$_POST['lastName']}",
    "{$_POST['class']}");
  SQL;
    mysqli_query($conn, $sql);
    header("Location: http://{$_SERVER['HTTP_HOST']}/index.php");
  }
}
