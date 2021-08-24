<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "admin")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

require 'validate.php';

$isLastInputCorrect = false;
$isStudent = !empty($_POST['class']);

if ($isStudent) {
  $isLastInputCorrect = isClassCorrect();
} else {
  $isLastInputCorrect = isPhoneCorrect();
}

if (!isEmpty('phone class') && $isLastInputCorrect) {
  require_once "../db.php";
  $conn = connectToDB();

  $rank = isset($_POST['class']) ? "students" : "teachers";
  $lastField = isset($_POST['class']) ? "class" : "phone";

  mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);
  try {
    mysqli_autocommit($conn, false);

    $sql = sprintf(
      "UPDATE %s SET
    `first_name` = '%s', 
    `last_name`= '%s', 
    `%s`='%s' 
    WHERE `id`=%s AND `user_id`=%s
    ",
      $rank,
      mysqli_real_escape_string($conn, $_POST['first_name']),
      mysqli_real_escape_string($conn, $_POST['last_name']),
      $lastField,
      mysqli_real_escape_string($conn, $_POST[$lastField]),
      mysqli_real_escape_string($conn, $_POST['typeid']),
      mysqli_real_escape_string($conn, $_POST['id'])
    );
    mysqli_query($conn, $sql);

    $sql = sprintf(
      "UPDATE users SET
      `email` = '%s' 
      WHERE `id`=%s
      ",
      mysqli_real_escape_string($conn, $_POST['email']),
      mysqli_real_escape_string($conn, $_POST['id'])
    );
    mysqli_query($conn, $sql);

    $_SESSION['snackalert'] = ["type" => "success", "text" => "The user has been edited"];
    mysqli_commit($conn);
  } catch (mysqli_sql_exception $e) {
    $_SESSION['snackalert'] = ["type" => "error", "text" => "The user could not be edited"];
    mysqli_rollback($conn);
    throw $e;
  }
} else {
  $_SESSION['snackalert'] = ["type" => "error", "text" => "The form was filled incorrectly"];
}
$get = "";
if ($_SESSION['deactivatedOnly'] === -1) $get = "?deactivatedOnly=true";
header("Location: http://{$_SERVER['HTTP_HOST']}/admin/users.php{$get}");
