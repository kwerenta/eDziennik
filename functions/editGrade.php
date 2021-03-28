<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

$isEmpty = false;

foreach ($_POST as $input => $value) {
  if ($value === null) {
    $isEmpty = true;
  }
}
if (!$isEmpty) {
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
