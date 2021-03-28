<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

require 'validate.php';

$isStudentOk = true;
$isCategoryOk = true;

if (!in_array($_POST['student_id'], array_column($_SESSION['students'], "id"))) {
  $isStudentOk = false;
}
if (!in_array($_POST['category'], array_column($_SESSION['categories'], "id"))) {
  $isCategoryOk = false;
}

if (!isEmpty() && isValueCorrect($_POST['grade'], 1, 6) && $isStudentOk && $isCategoryOk) {
  require "../db.php";
  $conn = connectToDB();

  $sql = sprintf(
    "UPDATE grades SET `grade`= %s, `description`='%s', `category_id`='%s' WHERE `id`=%s AND `student_id`=%s AND `teacher_id`=%s",
    mysqli_real_escape_string($conn, $_POST['grade']),
    mysqli_real_escape_string($conn, $_POST['description']),
    mysqli_real_escape_string($conn, $_POST['category']),
    mysqli_real_escape_string($conn, $_POST['grade_id']),
    mysqli_real_escape_string($conn, $_POST['student_id']),
    $_SESSION['user']['id']
  );
  mysqli_query($conn, $sql);
}

header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/grades.php");
