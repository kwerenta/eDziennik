<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

require 'validate.php';

$isStudentOk = in_array($_POST['student'], array_column($_SESSION['students'], "id"));
$isCategoryOk = in_array($_POST['category'], array_column($_SESSION['categories'], "id"));

if (!isEmpty('description') && $isCategoryOk && isValueCorrect($_POST['grade'], 1, 6) && $isStudentOk) {
  require "../db.php";
  $conn = connectToDB();
  $sql = <<<SQL
  INSERT INTO grades
  (`student_id`,
  `teacher_id`,
  `subject_id`,
  `category_id`,
  `grade`,
  `description`) 
  VALUES 
  ({$_POST['student']},
  {$_SESSION['user']['id']},
  {$_SESSION['subject']['id']},
  {$_POST['category']},
  {$_POST['grade']},
  "{$_POST['description']}")
SQL;
  mysqli_query($conn, $sql);
  if (mysqli_affected_rows($conn) > 0) {
    $_SESSION['snackalert'] = ["type" => "success", "text" => "Ocena została dodana"];
  } else {
    $_SESSION['snackalert'] = ["type" => "error", "text" => "Nie udało się dodać oceny"];
  }
} else {
  $_SESSION['snackalert'] = ["type" => "error", "text" => "Formularz został błędnie wypełniony"];
}
header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/grades.php");
