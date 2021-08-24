<?php
session_start();
require "../db.php";
$conn = connectToDB();

require 'validate.php';

if (!isEmpty() && isEmailCorrect()) {
  $binary = openssl_random_pseudo_bytes(4, $isStrong);
  if ($isStrong) {
    $sql = "SELECT `id` FROM users WHERE `email`='{$_POST['email']}'";
    $query = mysqli_query($conn, $sql);

    if ($query->num_rows === 0) {
      $_SESSION['formInfos']['error'] = "There is no such user";
      header("Location: http://{$_SERVER['HTTP_HOST']}/");
      exit();
    };

    $hex = bin2hex($binary);
    $hash = password_hash($hex, PASSWORD_BCRYPT);

    $id = mysqli_fetch_array($query);
    $sql = "SELECT `rank` FROM ranks WHERE `user_id` = {$id['id']}";
    $query = mysqli_query($conn, $sql);
    $rank = mysqli_fetch_array($query);

    $rank = isset($rank) ? ($rank === "1" ? "admins" : "teachers") : "students";
    $sql = sprintf(
      "SELECT `first_name`, `last_name` FROM %s WHERE `first_name`='%s' AND `last_name`='%s'",
      $rank,
      mysqli_real_escape_string($conn, $_POST['firstName']),
      mysqli_real_escape_string($conn, $_POST['lastName'])
    );
    $query = mysqli_query($conn, $sql);

    if ($query->num_rows === 0) {
      $_SESSION['formInfos']['error'] = "There is no such user";
      header("Location: http://{$_SERVER['HTTP_HOST']}/");
      exit();
    };

    $sql = sprintf(
      "UPDATE users SET `password` = '%s' WHERE `email`='%s'",
      $hash,
      mysqli_real_escape_string($conn, $_POST['email'])
    );
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
      $_SESSION['formInfos']['success'] = "Your new password is:<br><span title='Click to copy' class='form__newPassword'>{$hex}</span>";
    } else {
      $_SESSION['formInfos']['error'] = "The password could not be changed!";
    }
  } else {
    $_SESSION['formInfos']['error'] = "Error occured! Try again";
  }
} else {
  $_SESSION['formInfos']['error'] = "The form was filled incorrectly";
}

header("Location: http://{$_SERVER['HTTP_HOST']}/");
