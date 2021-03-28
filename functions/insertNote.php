<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

$isStudentOk = true;

if (!in_array($_POST['student'], array_column($_SESSION['students'], "id"))) {
  $isStudentOk = false;
}


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
}
header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/notes.php");
