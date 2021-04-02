<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

require 'validate.php';

$isStudentOk = true;

if (!in_array($_POST['student_id'], array_column($_SESSION['students'], "id"))) {
  $isStudentOk = false;
}

if (!isEmpty() && isValueCorrect($_POST['points'], -150, 150) && $isStudentOk) {
  require "../db.php";
  $conn = connectToDB();

  $sql = sprintf(
    "UPDATE notes SET `points`= %s, `description`='%s' WHERE `id`=%s AND `student_id`=%s AND `teacher_id`=%s",
    mysqli_real_escape_string($conn, $_POST['points']),
    mysqli_real_escape_string($conn, $_POST['description']),
    mysqli_real_escape_string($conn, $_POST['note_id']),
    mysqli_real_escape_string($conn, $_POST['student_id']),
    $_SESSION['user']['id']
  );
  mysqli_query($conn, $sql);

  if (mysqli_affected_rows($conn) > 0) {
    $_SESSION['snackalert'] = ["type" => "success", "text" => "Uwaga została zedytowana"];
  } else {
    $_SESSION['snackalert'] = ["type" => "error", "text" => "Nie udało się zedytować uwagi"];
  };
} else {
  $_SESSION['snackalert'] = ["type" => "error", "text" => "Formularz został błędnie wypełniony"];
}

header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/notes.php");
