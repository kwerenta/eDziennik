<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}
require 'validate.php';
$isStudentOk = in_array($_POST['student'], array_column($_SESSION['students'], "id"));

if (!isEmpty() && isValueCorrect($_POST['points'], -150, 150) && $isStudentOk) {
  require "../db.php";
  $conn = connectToDB();

  $sql = <<<SQL
  INSERT INTO notes
  (`student_id`,
  `teacher_id`,
  `points`,
  `description`,
  `date`) 
  VALUES 
  ({$_POST['student']},
  {$_SESSION['user']['id']},
  {$_POST['points']},
  "{$_POST['description']}",
  CURRENT_TIMESTAMP())
SQL;
  mysqli_query($conn, $sql);

  if (mysqli_affected_rows($conn) > 0) {
    $_SESSION['snackalert'] = ["type" => "success", "text" => "Uwaga została dodana"];
  } else {
    $_SESSION['snackalert'] = ["type" => "error", "text" => "Nie udało się dodać uwagi"];
  }
} else {
  $_SESSION['snackalert'] = ["type" => "error", "text" => "Formularz został błędnie wypełniony"];
}
header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/notes.php");
