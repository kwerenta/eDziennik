<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}
require 'validate.php';
$isStudentOk = in_array($_POST['student'], array_column($_SESSION['students'], "id"));

if (!isEmpty('description') && isValueCorrect($_POST['points'], -150, 150) && $isStudentOk) {
  require "../db.php";
  $conn = connectToDB();

  $sql = sprintf(
    <<<SQL
  INSERT INTO notes
  (`student_id`,
  `teacher_id`,
  `points`,
  `description`) 
  VALUES 
  (%s,
  {$_SESSION['user']['id']},
  %s,
  "%s")
SQL,
    mysqli_real_escape_string($conn, $_POST['student']),
    mysqli_real_escape_string($conn, $_POST['points']),
    mysqli_real_escape_string($conn, $_POST['description'])
  );
  mysqli_query($conn, $sql);

  if (mysqli_affected_rows($conn) > 0) {
    $_SESSION['snackalert'] = ["type" => "success", "text" => "The note has been inserted"];
  } else {
    $_SESSION['snackalert'] = ["type" => "error", "text" => "The note could not be inserted"];
  }
} else {
  $_SESSION['snackalert'] = ["type" => "error", "text" => "The form was filled incorrectly"];
}
header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/notes.php");
