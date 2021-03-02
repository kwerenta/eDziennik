<?php
require 'db.php';

$conn = connectToDB();

if ($_POST['firstName'] !== null && $_POST['lastName'] !== null && $_POST['email'] !== null && $_POST['password'] !== null && $_POST['confirmPassword'] !== null && $_POST['class'] !== null) {
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
    header('Location: index.php');
  }
}
