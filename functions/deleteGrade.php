<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

require "../db.php";
$conn = connectToDB();
$sql = "DELETE FROM grades WHERE `teacher_id`={$_SESSION['user']['id']} AND `student_id`={$_POST['student_id']} AND `id`={$_POST['grade_id']} AND `subject_id`={$_SESSION['subject']['id']}";
mysqli_query($conn, $sql);

header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/grades.php");
