<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

require "../db.php";
$conn = connectToDB();
$sql = sprintf(
  "DELETE FROM grades WHERE `teacher_id`=%s AND `student_id`=%s AND `id`=%s AND `subject_id`=%s",
  $_SESSION['user']['id'],
  mysqli_real_escape_string($conn, $_POST['student_id']),
  mysqli_real_escape_string($conn, $_POST['grade_id']),
  $_SESSION['subject']['id']
);
mysqli_query($conn, $sql);

header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/grades.php");
