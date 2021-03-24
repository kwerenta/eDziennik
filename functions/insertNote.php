<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

$isEmpty = false;
$isStudentOk = true;
$arePointsOk = true;

foreach ($_POST as $input => $value) {
  if ($value === null && $input !== "description") {
    $isEmpty = true;
  }
}

if (!in_array($_POST['student'], array_column($_SESSION['students'], "id"))) {
  $isStudentOk = false;
}
if ($_POST['points'] < -150 || $_POST['points'] > 150) {
  $arePointsOk = false;
}


if (!$isEmpty && $arePointsOk && $isStudentOk) {
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
